<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Queue;

/**
 * Handles one kind of message in a worker ([QUEUE-02]).
 *
 * The worker hands each message to the handler of its class. The classes the
 * registered handlers declare are also the only ones a consumer rebuilds from a
 * queue: a message nobody handles is never instantiated.
 *
 * Delivery is at least once: a handler is idempotent, or de-duplicates on
 * `$envelope->id`.
 */
interface MessageHandlerInterface
{
    /**
     * The message class this handler handles.
     *
     * @return class-string<MessageInterface>
     */
    public function handles(): string;

    /**
     * Handles one delivery. Returning means the message was handled; throwing
     * means the delivery failed, and the worker releases the message for another
     * attempt, or keeps it in the dead-letter store once its attempts are spent.
     */
    public function handle(MessageInterface $message, Envelope $envelope): void;
}
