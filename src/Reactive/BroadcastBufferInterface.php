<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Reactive;

use Waffle\Commons\Contracts\Service\ResettableInterface;

/**
 * Request-scoped buffer that accumulates {@see MutationRecord}s during a request
 * (REACTIVE-01).
 *
 * `#[Broadcast]` property write-hooks {@see self::record()} mutations here with no
 * I/O; a finish-request listener {@see self::drain()}s the buffer and pushes the
 * records over a {@see BroadcastTransportInterface}. As request-scoped state the
 * buffer is {@see ResettableInterface}: the kernel empties it between requests so
 * mutations never bleed across the worker loop.
 */
interface BroadcastBufferInterface extends ResettableInterface
{
    /**
     * Append a mutation to the buffer (called from a write-hook; no I/O).
     */
    public function record(MutationRecord $record): void;

    /**
     * Return every buffered mutation in record order and clear the buffer.
     *
     * @return list<MutationRecord>
     */
    public function drain(): array;
}
