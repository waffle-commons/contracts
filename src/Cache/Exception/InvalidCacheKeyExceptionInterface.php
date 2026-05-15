<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Cache\Exception;

use Psr\SimpleCache\InvalidArgumentException as PsrSimpleCacheInvalidArgumentException;

/**
 * Thrown when a cache key violates PSR-16 §1.3 (reserved character set, length,
 * or empty key).
 *
 * Extends both the Waffle marker and PSR-16's invalid-argument marker so that
 * callers using either type-hint will catch it.
 */
interface InvalidCacheKeyExceptionInterface extends CacheExceptionInterface, PsrSimpleCacheInvalidArgumentException
{
    /** Returns the offending key (verbatim, as supplied by the caller). */
    public function getKey(): string;
}
