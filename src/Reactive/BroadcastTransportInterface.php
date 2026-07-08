<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Reactive;

/**
 * Sink that publishes drained {@see MutationRecord}s to real-time subscribers
 * (REACTIVE-01).
 *
 * Implementations bridge to a concrete delivery channel — Server-Sent Events,
 * a Mercure hub, a WebSocket gateway — and are invoked by the finish-request
 * broadcast flush, never from inside a property write-hook. External transport
 * SDKs (e.g. a Mercure client) are wrapped in their own component to keep the
 * contracts perimeter dependency-free.
 */
interface BroadcastTransportInterface
{
    /**
     * Publish a single mutation to its channel's subscribers.
     */
    public function push(MutationRecord $record): void;

    /**
     * Publish a batch of mutations, in record order.
     *
     * @param list<MutationRecord> $records
     */
    public function pushBatch(array $records): void;
}
