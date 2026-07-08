<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry\Metrics;

/**
 * A source of metric samples gathered at scrape time (e.g. process memory, GC
 * cycles, connection-pool utilisation). Collectors are stateless: they read live
 * values when {@see self::collect()} is called rather than accumulating state.
 */
interface MetricsCollectorInterface
{
    /**
     * Sample the source right now.
     *
     * @return iterable<MetricSample>
     */
    public function collect(): iterable;
}
