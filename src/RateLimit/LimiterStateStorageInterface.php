<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\RateLimit;

use InvalidArgumentException;
use Waffle\Commons\Contracts\RateLimit\Exception\StateStorageExceptionInterface;

/**
 * The shared state behind rate limiting ([NET-01], RFC-024 §5.1): token buckets that every worker sees.
 *
 * Each operation is atomic — in Redis, one Lua script — so concurrent workers on the same key never admit
 * more calls than the bucket holds. A PSR-16 cache cannot do that (`get` then `set` races), which is why
 * this is not a cache contract. The Redis implementation lives in `waffle-commons/data`, over its
 * connection pool; an in-memory implementation is correct for a single worker only.
 */
interface LimiterStateStorageInterface
{
    /**
     * Atomically refills the bucket of `$key` for the time elapsed since its last use, then takes `$cost`
     * tokens if it holds that many. A bucket seen for the first time starts full.
     *
     * The storage keeps the time itself (the Redis server clock, or an injected clock), so workers on hosts
     * whose clocks drift still agree on every bucket.
     *
     * @param string $key  The bucket's key; never empty.
     * @param int    $cost Between 1 and the bucket capacity.
     *
     * @throws InvalidArgumentException       When the key is empty or the cost does not fit the bucket.
     * @throws StateStorageExceptionInterface When the storage is unreachable or refuses the operation.
     */
    public function consume(string $key, TokenBucket $bucket, int $cost): RateLimitDecision;
}
