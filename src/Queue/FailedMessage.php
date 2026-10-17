<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Queue;

use DateTimeImmutable;

/**
 * A message that will not be delivered again, kept in the dead-letter store
 * with its full envelope and the reason its last delivery failed ([QUEUE-01]).
 */
final readonly class FailedMessage
{
    /**
     * @param Envelope          $envelope The envelope as it would be delivered again: its id, its trace context,
     *                                    and its attempts, which count every failed delivery, the last one
     *                                    included.
     * @param string            $reason   Why the last delivery failed (the exception class and message).
     * @param DateTimeImmutable $failedAt When the message was given up on.
     */
    public function __construct(
        public Envelope $envelope,
        public string $reason,
        public DateTimeImmutable $failedAt,
    ) {}
}
