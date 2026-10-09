<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Queue;

use DateTimeImmutable;
use Waffle\Commons\Contracts\Queue\Exception\QueueExceptionInterface;

/**
 * Puts messages on a queue ([QUEUE-01]). Code that starts background work
 * depends on this interface only.
 */
interface QueueDispatcherInterface
{
    public const string DEFAULT_QUEUE = 'default';

    /**
     * Queues a message and returns its envelope.
     *
     * The dispatcher assigns the id and records the current trace context. The
     * message is available at once, or from `$availableAt` for delayed work.
     *
     * @throws QueueExceptionInterface When the queue cannot take the message.
     */
    public function dispatch(
        MessageInterface $message,
        string $queue = self::DEFAULT_QUEUE,
        ?DateTimeImmutable $availableAt = null,
    ): Envelope;
}
