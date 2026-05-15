<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Cache\Exception;

use Psr\SimpleCache\CacheException as PsrSimpleCacheException;
use Throwable;

/**
 * Marker for any failure raised by the Waffle Cache subsystem.
 *
 * Extends `\Throwable` and `Psr\SimpleCache\CacheException` so callers may
 * catch either the Waffle marker or the PSR-16 marker. Concrete exceptions
 * (`InvalidCacheKeyExceptionInterface`, `CacheBackendUnavailableExceptionInterface`)
 * descend from this.
 */
interface CacheExceptionInterface extends Throwable, PsrSimpleCacheException {}
