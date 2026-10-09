<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Mailer;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use ReflectionClass;
use Waffle\Commons\Contracts\Attribute\Dto;
use Waffle\Commons\Contracts\Mailer\Email;
use Waffle\Commons\Contracts\Queue\MessageInterface;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(Email::class)]
final class EmailTest extends AbstractTestCase
{
    public function testCarriesEveryPartOfTheEmail(): void
    {
        $email = new Email(
            from: 'billing@example.com',
            to: ['ada@example.com', 'grace@example.com'],
            subject: 'Your invoice',
            text: 'Please find your invoice.',
            html: '<p>Please find your invoice.</p>',
            cc: ['accounts@example.com'],
            bcc: ['archive@example.com'],
            replyTo: 'support@example.com',
        );

        static::assertSame('billing@example.com', $email->from);
        static::assertSame(['ada@example.com', 'grace@example.com'], $email->to);
        static::assertSame('Your invoice', $email->subject);
        static::assertSame('Please find your invoice.', $email->text);
        static::assertSame('<p>Please find your invoice.</p>', $email->html);
        static::assertSame(['accounts@example.com'], $email->cc);
        static::assertSame(['archive@example.com'], $email->bcc);
        static::assertSame('support@example.com', $email->replyTo);
    }

    public function testATextOrAnHtmlBodyIsEnough(): void
    {
        $text = new Email('billing@example.com', ['ada@example.com'], 'Your invoice', text: 'Hello.');
        $html = new Email('billing@example.com', ['ada@example.com'], 'Your invoice', html: '<p>Hello.</p>');

        static::assertNull($text->html);
        static::assertNull($html->text);
        static::assertSame([], $text->cc);
        static::assertSame([], $text->bcc);
        static::assertNull($text->replyTo);
    }

    public function testIsAQueueMessageAndADto(): void
    {
        $email = new Email('billing@example.com', ['ada@example.com'], 'Your invoice', text: 'Hello.');

        static::assertInstanceOf(MessageInterface::class, $email);
        static::assertCount(1, new ReflectionClass(Email::class)->getAttributes(Dto::class));
    }

    public function testRecipientsBecomeAList(): void
    {
        // Built as a hydrator builds it: the arguments are not checked statically.
        $email = new ReflectionClass(Email::class)->newInstanceArgs([
            'from' => 'billing@example.com',
            'to' => [3 => 'ada@example.com', 7 => 'grace@example.com'],
            'subject' => 'Your invoice',
            'text' => 'Hello.',
        ]);

        static::assertInstanceOf(Email::class, $email);
        static::assertSame(['ada@example.com', 'grace@example.com'], $email->to);
    }

    /**
     * @return iterable<string, array{array<string, string|array|null>, string}>
     */
    public static function invalidEmails(): iterable
    {
        yield 'invalid sender' => [['from' => 'not an address'], 'The "from" address "not an address" is not valid.'];
        yield 'no recipient' => [['to' => []], 'An email needs at least one recipient.'];
        yield 'invalid recipient' => [['to' => ['ada@example.com', 'nope']], 'The "to" address "nope" is not valid.'];
        yield 'header injection in an address' => [
            ['to' => ["ada@example.com\r\nBcc: victim@example.com"]],
            'is not valid.',
        ];
        yield 'empty subject' => [['subject' => ''], 'An email subject is one line of text.'];
        yield 'header injection in the subject' => [
            ['subject' => "Hello\r\nBcc: victim@example.com"],
            'An email subject is one line of text.',
        ];
        yield 'invalid copy' => [['cc' => ['nope']], 'The "cc" address "nope" is not valid.'];
        yield 'invalid blind copy' => [['bcc' => ['nope']], 'The "bcc" address "nope" is not valid.'];
        yield 'invalid reply-to' => [['replyTo' => 'nope'], 'The "replyTo" address "nope" is not valid.'];
        yield 'no body' => [['text' => null], 'An email needs a text or an HTML body.'];
        yield 'a recipient that is not a string' => [
            ['to' => ['ada@example.com', 42]],
            'Every "to" address must be a string.',
        ];
    }

    /**
     * @param array<string, string|array|null> $override
     */
    #[DataProvider('invalidEmails')]
    public function testRefusesAnInvalidEmail(array $override, string $reason): void
    {
        $arguments = [
            'from' => 'billing@example.com',
            'to' => ['ada@example.com'],
            'subject' => 'Your invoice',
            'text' => 'Hello.',
            ...$override,
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($reason);

        // Built as a hydrator builds it: the arguments are not checked statically.
        new ReflectionClass(Email::class)->newInstanceArgs($arguments);
    }
}
