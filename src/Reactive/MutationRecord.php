<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Reactive;

/**
 * An immutable record of one broadcast-flagged property mutation (REACTIVE-01).
 *
 * Enqueued by a `#[Broadcast]` property's `set` write-hook into the request-scoped
 * {@see BroadcastBufferInterface} and later serialized and pushed by the
 * finish-request flush. It captures what changed, on which channel, without
 * performing any I/O at mutation time.
 */
final readonly class MutationRecord
{
    /**
     * @param string $channel     Logical channel the mutation publishes on.
     * @param string $entityClass FQCN of the DTO/Entity that changed.
     * @param string $property    Name of the mutated property.
     * @param mixed  $value       The new property value (serialized at flush time).
     */
    public function __construct(
        public string $channel,
        public string $entityClass,
        public string $property,
        public mixed $value,
    ) {}
}
