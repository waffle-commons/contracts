<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Mailer;

use InvalidArgumentException;
use Waffle\Commons\Contracts\Attribute\Dto;
use Waffle\Commons\Contracts\Attribute\ListOf;
use Waffle\Commons\Contracts\Queue\MessageInterface;

use function array_key_exists;
use function array_keys;
use function filter_var;
use function is_string;
use function sprintf;
use function strpbrk;

/**
 * A transactional email ([QUEUE-03]).
 *
 * It is also a queue message, so mail is sent in the background: dispatch the
 * email, and the worker hands it to the {@see MailerInterface}. Its hooks check
 * every address and keep CR and LF out of the subject, so a value from a request
 * cannot inject a header. Addresses are plain (`ada@example.com`), without a
 * display name.
 */
#[Dto]
final class Email implements MessageInterface
{
    /**
     * @param list<string> $to  At least one recipient.
     * @param list<string> $cc
     * @param list<string> $bcc
     *
     * @throws InvalidArgumentException When an address is invalid, the subject is empty or spans lines, there is
     *                                  no recipient, or neither body is given.
     */
    public function __construct(
        public private(set) string $from {
            set(string $value) {
                $this->from = self::address($value, 'from');
            }
        },
        #[ListOf('string')]
        public private(set) array $to {
            set(array $value) {
                if ($value === []) {
                    throw new InvalidArgumentException('An email needs at least one recipient.');
                }

                $this->to = self::addresses($value, 'to');
            }
        },
        public private(set) string $subject {
            set(string $value) {
                if ($value === '' || strpbrk($value, "\r\n") !== false) {
                    throw new InvalidArgumentException('An email subject is one line of text.');
                }

                $this->subject = $value;
            }
        },
        public private(set) ?string $text = null,
        public private(set) ?string $html = null,
        #[ListOf('string')]
        public private(set) array $cc = [] {
            set(array $value) {
                $this->cc = self::addresses($value, 'cc');
            }
        },
        #[ListOf('string')]
        public private(set) array $bcc = [] {
            set(array $value) {
                $this->bcc = self::addresses($value, 'bcc');
            }
        },
        public private(set) ?string $replyTo = null {
            set(?string $value) {
                $this->replyTo = $value === null ? null : self::address($value, 'replyTo');
            }
        },
    ) {
        if ($text === null && $html === null) {
            throw new InvalidArgumentException('An email needs a text or an HTML body.');
        }
    }

    /**
     * @throws InvalidArgumentException When `$address` is not a valid email address.
     */
    private static function address(string $address, string $field): string
    {
        if (filter_var($address, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException(sprintf('The "%s" address "%s" is not valid.', $field, $address));
        }

        return $address;
    }

    /**
     * The addresses as a list, each one checked in place.
     *
     * @return list<string>
     *
     * @throws InvalidArgumentException When one of the addresses is not a valid email address.
     */
    private static function addresses(array $addresses, string $field): array
    {
        $checked = [];
        // The values are untyped: each one is narrowed in place, never bound on its own.
        foreach (array_keys($addresses) as $key) {
            if (!array_key_exists($key, $addresses) || !is_string($addresses[$key])) {
                throw new InvalidArgumentException(sprintf('Every "%s" address must be a string.', $field));
            }

            $checked[] = self::address($addresses[$key], $field);
        }

        return $checked;
    }
}
