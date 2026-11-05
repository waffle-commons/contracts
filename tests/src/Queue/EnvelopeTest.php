<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Queue;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Waffle\Commons\Contracts\Queue\Envelope;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(Envelope::class)]
final class EnvelopeTest extends AbstractTestCase
{
    public function testCarriesTheMessageAndWhatDeliveryNeeds(): void
    {
        $message = new SendInvoice('inv-42');
        $availableAt = new DateTimeImmutable('2026-10-09T09:00:00+00:00');
        $trace = ['traceparent' => '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01'];

        $envelope = new Envelope('msg-1', $message, 'invoices', $availableAt, 2, $trace, '1700000000000-0');

        static::assertSame('msg-1', $envelope->id);
        static::assertSame($message, $envelope->message);
        static::assertSame('invoices', $envelope->queue);
        static::assertSame($availableAt, $envelope->availableAt);
        static::assertSame(2, $envelope->attempts);
        static::assertSame($trace, $envelope->traceContext);
        static::assertSame('1700000000000-0', $envelope->receipt);
    }

    public function testANewEnvelopeHasNoFailedAttemptNoTraceAndNoReceipt(): void
    {
        $envelope = self::envelope();

        static::assertSame(0, $envelope->attempts);
        static::assertSame([], $envelope->traceContext);
        static::assertNull($envelope->receipt);
    }

    public function testAReceivedCopyCarriesTheReceiptAndLeavesTheOriginalAlone(): void
    {
        $envelope = self::envelope();

        $received = $envelope->withReceipt('1700000000000-0');

        static::assertNotSame($envelope, $received);
        static::assertSame('1700000000000-0', $received->receipt);
        static::assertNull($envelope->receipt);
        static::assertSame($envelope->id, $received->id);
    }

    public function testTheNextAttemptCountsOneMoreFailureAndDropsTheReceipt(): void
    {
        $later = new DateTimeImmutable('2026-10-09T09:05:00+00:00');
        $received = self::envelope()->withReceipt('1700000000000-0');

        $next = $received->withNextAttempt($later);

        static::assertSame(1, $next->attempts);
        static::assertSame($later, $next->availableAt);
        static::assertNull($next->receipt);
        static::assertSame($received->id, $next->id);
        static::assertSame($received->message, $next->message);
        static::assertSame(0, $received->attempts);
    }

    /**
     * @return iterable<string, array{string, string, int, string}>
     */
    public static function invalidEnvelopes(): iterable
    {
        yield 'empty id' => ['', 'invoices', 0, 'An envelope id must not be empty.'];
        yield 'empty queue' => ['msg-1', '', 0, 'An envelope queue must not be empty.'];
        yield 'negative attempts' => [
            'msg-1',
            'invoices',
            -1,
            'An envelope cannot have a negative number of attempts.',
        ];
    }

    #[DataProvider('invalidEnvelopes')]
    public function testRefusesAnInvalidEnvelope(string $id, string $queue, int $attempts, string $reason): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($reason);

        new Envelope($id, new SendInvoice('inv-42'), $queue, new DateTimeImmutable(), $attempts);
    }

    private static function envelope(): Envelope
    {
        return new Envelope(
            'msg-1',
            new SendInvoice('inv-42'),
            'invoices',
            new DateTimeImmutable('2026-10-09T09:00:00+00:00'),
        );
    }
}
