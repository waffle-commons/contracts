<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry\Metrics;

/**
 * Live utilisation of a connection pool, sampled for the `/waffle-metrics`
 * endpoint. Implemented by the adaptive pooler (RFC-022 / AXE 4 `DBAL-01`); until
 * a real pool is bound the metrics collector reports zeros.
 */
interface PoolStatsInterface
{
    /** Connections currently leased to in-flight requests. */
    public function activeLeases(): int;

    /** Connections sitting idle in the pool, ready to lease. */
    public function idle(): int;

    /** The pool's maximum capacity. */
    public function capacity(): int;
}
