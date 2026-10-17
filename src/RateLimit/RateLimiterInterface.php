<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\RateLimit;

use InvalidArgumentException;

/**
 * A configured rate limiter ([NET-01], RFC-017 §3.1): one token bucket, one storage, one failure mode.
 *
 * The rate-limit middleware keys it by client IP, authenticated subject or API token; an authentication
 * endpoint keys it by the account under attack. Its state lives in shared storage
 * ({@see LimiterStateStorageInterface}), never in worker memory.
 */
interface RateLimiterInterface
{
    /**
     * Takes `$cost` tokens from the bucket of `$key`.
     *
     * A storage outage never surfaces as an exception: the limiter applies its failure mode
     * (`on_storage_failure`, RFC-017 §4) and says so in the decision ({@see RateLimitDecision::$enforced}).
     *
     * @param string $key  The bucket's key, e.g. "ip:203.0.113.7" or "login:alice"; never empty.
     * @param int    $cost Between 1 and the bucket capacity.
     *
     * @throws InvalidArgumentException When the key is empty or the cost does not fit the bucket.
     */
    public function consume(string $key, int $cost = 1): RateLimitDecision;
}
