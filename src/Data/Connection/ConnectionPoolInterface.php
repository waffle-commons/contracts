<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Connection;

/**
 * Stateless, worker-safe pool of reusable backend connections.
 *
 * Designed for FrankenPHP resident-worker mode: a small set of connections is
 * kept warm across requests instead of being opened and torn down per request.
 * The pool is backend-neutral — it leases {@see ConnectionInterface} handles that
 * wrap a relational `PDO`, a Redis client, or any other driver — so relational and
 * key-value pooling share one contract. Relational consumers depend on the
 * narrowed {@see RelationalConnectionPoolInterface} for typed `PDO` access.
 *
 * Implementations MUST health-check a connection before dispensing it
 * ("heal-on-lease"): a dropped socket is transparently re-established so a single
 * dead connection never surfaces to the caller. Implementations are also expected
 * to implement {@see \Waffle\Commons\Contracts\Service\ResettableInterface} so the
 * kernel can roll back dangling transactions and recycle handles between requests.
 */
interface ConnectionPoolInterface
{
    /**
     * Borrow a healthy connection lease from the pool.
     *
     * The returned lease wraps a handle that has passed a lightweight liveness
     * probe; a dropped socket is reconnected transparently before the lease is
     * returned.
     *
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When no healthy connection can be established.
     */
    public function acquire(): ConnectionInterface;

    /**
     * Return a previously acquired lease to the idle set for later reuse.
     *
     * Releasing a lease that did not originate from this pool is a no-op (fail-soft).
     */
    public function release(ConnectionInterface $connection): void;
}
