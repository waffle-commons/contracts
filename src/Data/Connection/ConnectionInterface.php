<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Connection;

/**
 * Backend-neutral handle leased from a {@see ConnectionPoolInterface}.
 *
 * A connection wraps an underlying driver handle (a relational `PDO`, a Redis
 * client, a network stream, …) so the pool surface can stay free of any concrete
 * driver or extension type. Callers that need the concrete handle narrow to the
 * matching sub-interface — {@see PdoConnectionInterface}, {@see RedisConnectionInterface}
 * — which exposes it through a single typed accessor.
 *
 * Implementations are request-scoped leases: the owning pool creates one on
 * {@see ConnectionPoolInterface::acquire()} and reclaims the underlying handle on
 * {@see ConnectionPoolInterface::release()}.
 */
interface ConnectionInterface
{
    /**
     * Category of the underlying driver handle (relational, Redis, stream).
     */
    public function kind(): ConnectionKind;

    /**
     * Lightweight liveness probe.
     *
     * Returns false when the underlying socket has dropped so the owning pool can
     * cull and transparently re-establish the handle ("heal-on-lease") before it
     * ever reaches a caller.
     */
    public function isAlive(): bool;

    /**
     * Stable identity of the underlying handle.
     *
     * Two leases wrapping the same physical connection report the same id, so a
     * connection can never be double-pooled or double-counted across the request.
     */
    public function id(): int;
}
