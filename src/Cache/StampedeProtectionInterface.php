<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Cache;

/**
 * Optional capability: cache adapters that protect against the [Cache Stampede]
 * (https://en.wikipedia.org/wiki/Cache_stampede) problem implement this in
 * addition to `CacheInterface`.
 *
 * The reference algorithm is XFetch (Vattani et al., 2015): when an entry is
 * close to expiry, *one* worker probabilistically recomputes early while the
 * rest continue to read the stale-but-valid value. The `$beta` parameter
 * tunes that probability — higher beta = more aggressive early recomputation.
 *
 * Implementations MUST be atomic with respect to concurrent `compute()` calls
 * on the same `$key` (RFC-013 §4): only ONE invocation of `$callback` is
 * guaranteed across colliding workers.
 *
 * @template T of mixed
 */
interface StampedeProtectionInterface
{
    /**
     * Returns the cached value for $key, computing it via $callback if absent
     * or if the XFetch heuristic decides the entry is about to expire.
     *
     * @param callable(): T $callback Pure value-producer. Must NOT have side
     *                                effects beyond returning the value (the
     *                                framework may invoke it multiple times in
     *                                degraded mode).
     * @param int           $ttl      Seconds until the produced value expires.
     * @param float         $beta     XFetch tuning factor (>= 0.0). `0.0`
     *                                disables early recomputation; `1.0` is
     *                                the canonical XFetch default; higher
     *                                values are more aggressive.
     *
     * @return T
     */
    public function compute(string $key, callable $callback, int $ttl, float $beta = 1.0): mixed;
}
