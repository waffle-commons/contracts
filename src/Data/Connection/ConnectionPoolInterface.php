<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Connection;

use PDO;

/**
 * Stateless, worker-safe pool of reusable relational (PDO) connections.
 *
 * Designed for FrankenPHP resident-worker mode: a small set of connections is
 * kept warm across requests instead of being opened and torn down per request.
 * Implementations MUST health-check a connection before dispensing it
 * ("ping-before-dispense") and transparently re-establish a dropped socket, so a
 * single dead connection never surfaces to the caller.
 *
 * Implementations are expected to also implement
 * {@see \Waffle\Commons\Contracts\Service\ResettableInterface} so the kernel can
 * roll back dangling transactions and recycle handles between requests.
 */
interface ConnectionPoolInterface
{
    /**
     * Borrow a healthy connection from the pool.
     *
     * The returned handle has passed a lightweight liveness probe; a dropped
     * socket is reconnected transparently before the handle is returned.
     *
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When no healthy connection can be established.
     */
    public function acquire(): PDO;

    /**
     * Return a previously acquired connection to the idle set for later reuse.
     */
    public function release(PDO $connection): void;
}
