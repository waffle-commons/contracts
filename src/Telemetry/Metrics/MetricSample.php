<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry\Metrics;

use Waffle\Commons\Contracts\Telemetry\Metrics\Enum\MetricType;

/**
 * One exported metric reading — a name, its {@see MetricType}, a value and
 * optional labels — ready to be rendered into the Prometheus exposition format.
 */
final readonly class MetricSample
{
    /**
     * @param array<string, string> $labels
     */
    public function __construct(
        public string $name,
        public MetricType $type,
        public float $value,
        public array $labels = [],
        public string $help = '',
    ) {}
}
