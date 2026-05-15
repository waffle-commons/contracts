<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Cache;

use Psr\SimpleCache\CacheInterface as PsrSimpleCacheInterface;

/**
 * Waffle marker for any PSR-16 compatible cache (RFC-013).
 *
 * This interface intentionally does not add methods beyond PSR-16 — its purpose
 * is to give the Waffle ecosystem a stable type-hint that signals "this is a
 * Waffle-blessed cache" while remaining 100% interchangeable with vanilla PSR-16.
 *
 * Implementations that protect against cache stampede SHOULD additionally
 * implement `StampedeProtectionInterface`.
 */
interface CacheInterface extends PsrSimpleCacheInterface {}
