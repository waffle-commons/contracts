<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Cache;

use Psr\Cache\CacheItemPoolInterface as PsrCacheItemPoolInterface;

/**
 * Waffle marker over PSR-6 (RFC-013).
 *
 * Provided so future Waffle-specific decorators (tags, cache-warming hooks)
 * can be layered without modifying the PSR-6 contract itself. Initially adds
 * no methods — implementations are pure PSR-6 pools.
 */
interface CacheItemPoolInterface extends PsrCacheItemPoolInterface {}
