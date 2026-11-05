<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Queue;

use DateTimeImmutable;
use Waffle\Commons\Contracts\Queue\Exception\QueueExceptionInterface;

/**
 * Takes messages off a queue for a worker ([QUEUE-01]).
 *
 * A received message is in flight until the worker settles it: `acknowledge()`
 * when it was handled, `release()` to deliver it again later. A delivery that is
 * never settled (the worker crashed) is delivered again, to this worker or
 * another, once the transport reclaims it: no message is lost.
 */
interface QueueConsumerInterface
{
    /**
     * The next message available on `$queue`, waiting up to `$timeoutMs`
     * milliseconds (0: do not wait), or null when none became available.
     *
     * The envelope carries the receipt of this delivery.
     *
     * @throws QueueExceptionInterface When the queue cannot be read.
     */
    public function receive(string $queue, int $timeoutMs = 0): ?Envelope;

    /**
     * The message was handled: it is never delivered again.
     *
     * @throws QueueExceptionInterface When the queue cannot record it.
     */
    public function acknowledge(Envelope $envelope): void;

    /**
     * The delivery failed: the message comes back, as
     * `$envelope->withNextAttempt($availableAt)`, for another delivery from
     * `$availableAt`.
     *
     * @throws QueueExceptionInterface When the queue cannot take it back.
     */
    public function release(Envelope $envelope, DateTimeImmutable $availableAt): void;
}
