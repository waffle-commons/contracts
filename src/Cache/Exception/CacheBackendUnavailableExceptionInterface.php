<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Cache\Exception;

/**
 * Thrown when the underlying cache backend cannot be reached (e.g. Redis
 * connection refused, file cache directory unwritable).
 *
 * Per RFC-013 §4 "Graceful Degradation", callers may catch this specific
 * exception to fall back to a degraded mode (in-memory cache, recompute on
 * every request) while logging the outage.
 */
interface CacheBackendUnavailableExceptionInterface extends CacheExceptionInterface
{
    /**
     * Returns the backend identifier (e.g. "redis", "file", "memcached")
     * for diagnostics and structured logging.
     */
    public function getBackend(): string;
}
