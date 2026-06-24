<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Connection;

/**
 * A Redis connection lease exposing its underlying client handle.
 *
 * The handle is typed as {@see object} on purpose: the contracts package must not
 * assume the `ext-redis` (`\Redis`/`\Relay`) extension is installed, so the
 * concrete client type lives only in the implementing component (`data`). Callers
 * that know their wiring narrow the returned object to their client class.
 */
interface RedisConnectionInterface extends ConnectionInterface
{
    /**
     * The live Redis client handle backing this lease.
     *
     * Typed as `object` to keep `ext-redis` out of the contracts perimeter; the
     * concrete implementation returns the configured `\Redis`/`\Relay` instance.
     */
    public function client(): object;
}
