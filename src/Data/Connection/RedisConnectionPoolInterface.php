<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Connection;

/**
 * A {@see ConnectionPoolInterface} that leases Redis ({@see RedisConnectionInterface})
 * client handles.
 *
 * The key-value counterpart to {@see RelationalConnectionPoolInterface}: consumers
 * depending on this narrowed contract get a statically-typed
 * {@see RedisConnectionInterface} from {@see self::acquire()} (covariantly narrowed
 * from the parent, legal in PHP 8.5) without the generic pool surface ever
 * exposing an `ext-redis` type.
 */
interface RedisConnectionPoolInterface extends ConnectionPoolInterface
{
    /**
     * Borrow a healthy Redis client lease from the pool.
     *
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When no healthy client can be established.
     */
    #[\Override]
    public function acquire(): RedisConnectionInterface;
}
