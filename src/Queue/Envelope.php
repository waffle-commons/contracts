<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Queue;

use DateTimeImmutable;
use InvalidArgumentException;

/**
 * A message on its way through a queue, with what delivery needs to know
 * ([QUEUE-01]).
 *
 * The dispatcher creates it; a consumer hands it to the worker with the
 * transport's receipt of that delivery. It is immutable from outside: the
 * `with` copies are the only way to change it, and they run the same checks as
 * the constructor.
 */
final class Envelope
{
    /**
     * @param string                $id           Unique and stable across deliveries: handlers de-duplicate on it.
     * @param string                $queue        The queue the message was dispatched to.
     * @param DateTimeImmutable     $availableAt  No consumer delivers the message before this instant.
     * @param int                   $attempts     The deliveries that already failed: 0 on the first delivery.
     * @param array<string, string> $traceContext The W3C trace context (`traceparent`, `tracestate`) of the
     *                                            code that dispatched it, so the worker continues the trace.
     * @param string|null           $receipt      The transport's handle for the current delivery (a Redis
     *                                            stream entry id); null until a consumer receives it.
     */
    public function __construct(
        public private(set) string $id {
            set(string $value) {
                if ($value === '') {
                    throw new InvalidArgumentException('An envelope id must not be empty.');
                }

                $this->id = $value;
            }
        },
        public private(set) MessageInterface $message,
        public private(set) string $queue {
            set(string $value) {
                if ($value === '') {
                    throw new InvalidArgumentException('An envelope queue must not be empty.');
                }

                $this->queue = $value;
            }
        },
        public private(set) DateTimeImmutable $availableAt,
        public private(set) int $attempts = 0 {
            set(int $value) {
                if ($value < 0) {
                    throw new InvalidArgumentException('An envelope cannot have a negative number of attempts.');
                }

                $this->attempts = $value;
            }
        },
        public private(set) array $traceContext = [],
        public private(set) ?string $receipt = null,
    ) {}

    /**
     * A copy carrying the transport's receipt of a delivery.
     */
    public function withReceipt(string $receipt): self
    {
        return clone($this, ['receipt' => $receipt]);
    }

    /**
     * The copy to deliver again after a failed delivery: one more attempt,
     * available from `$availableAt`, with no receipt yet.
     */
    public function withNextAttempt(DateTimeImmutable $availableAt): self
    {
        return clone($this, ['attempts' => $this->attempts + 1, 'availableAt' => $availableAt, 'receipt' => null]);
    }
}
