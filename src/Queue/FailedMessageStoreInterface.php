<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Queue;

use Waffle\Commons\Contracts\Queue\Exception\QueueExceptionInterface;

/**
 * The dead-letter store: where a worker puts a message once its attempts are
 * exhausted, so that nothing is dropped silently ([QUEUE-01]).
 */
interface FailedMessageStoreInterface
{
    /**
     * Keeps a message that will not be delivered again, with the reason its last
     * delivery failed.
     *
     * @throws QueueExceptionInterface When the store cannot keep it.
     */
    public function store(Envelope $envelope, string $reason): void;

    /**
     * The failed messages, oldest first, at most `$limit` of them.
     *
     * @return list<FailedMessage>
     *
     * @throws QueueExceptionInterface When the store cannot be read.
     */
    public function list(int $limit = 100): array;

    /**
     * Forgets a failed message, once it was dispatched again or discarded.
     *
     * @throws QueueExceptionInterface When the store cannot forget it.
     */
    public function remove(string $id): void;
}
