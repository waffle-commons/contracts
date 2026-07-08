<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry\Metrics\Enum;

/**
 * The Prometheus/OpenMetrics type of a {@see \Waffle\Commons\Contracts\Telemetry\Metrics\MetricSample}.
 */
enum MetricType: string
{
    /** Monotonic cumulative total (e.g. requests served). */
    case Counter = 'counter';
    /** Point-in-time value that can rise and fall (e.g. memory bytes). */
    case Gauge = 'gauge';
    /** Distribution of observed values (e.g. request duration seconds). */
    case Histogram = 'histogram';
}
