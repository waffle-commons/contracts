<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Connection;

/**
 * A {@see ConnectionPoolInterface} that leases relational ({@see PdoConnectionInterface})
 * connections.
 *
 * Relational repositories and the failsafe transaction middleware depend on this
 * narrowed contract so {@see self::acquire()} is statically typed as a
 * {@see PdoConnectionInterface} — giving them typed `PDO` access without the
 * generic pool surface ever leaking a `PDO` type. The return type is covariantly
 * narrowed from the parent (legal in PHP 8.5).
 */
interface RelationalConnectionPoolInterface extends ConnectionPoolInterface
{
    /**
     * Borrow a healthy relational connection lease from the pool.
     *
     * While a request scope is open (see {@see self::beginRequestScope()}), every
     * call returns the SAME pinned lease, so all repository work in the request
     * shares one connection.
     *
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When no healthy connection can be established.
     */
    #[\Override]
    public function acquire(): PdoConnectionInterface;

    /**
     * Open a request-scoped connection affinity and return the pinned lease.
     *
     * For the duration of the scope, {@see self::acquire()} returns this same
     * lease and {@see self::release()} of it is a no-op — so the failsafe
     * transaction middleware can begin ONE transaction on the pinned connection
     * and have every downstream repository write run inside it (DBAL-02). Without
     * this, each repository would acquire an independent connection and the
     * middleware's transaction would not contain their writes.
     *
     * Idempotent within a scope: a nested call returns the already-pinned lease.
     *
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When no healthy connection can be established.
     */
    public function beginRequestScope(): PdoConnectionInterface;

    /**
     * Close the request-scoped affinity and return the pinned connection to the
     * idle set. Safe to call when no scope is open (no-op).
     */
    public function endRequestScope(): void;
}
