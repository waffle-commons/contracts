<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry\Metrics;

/**
 * Records worker metrics. To honour the FrankenPHP statelessness mandate,
 * implementations MUST keep cumulative state OUT of the resident worker heap
 * (e.g. in APCu shared memory); the default {@see NullMetricsRegistry} records
 * nothing. The framework core depends only on this contract.
 */
interface MetricsRegistryInterface
{
    /**
     * Add $value (default 1) to a monotonic counter.
     *
     * @param array<string, string> $labels
     */
    public function increment(string $name, float $value = 1.0, array $labels = []): void;

    /**
     * Observe a single value into a histogram (e.g. a request duration in seconds).
     *
     * @param array<string, string> $labels
     */
    public function observe(string $name, float $value, array $labels = []): void;

    /**
     * Set a gauge to an absolute point-in-time value.
     *
     * @param array<string, string> $labels
     */
    public function gauge(string $name, float $value, array $labels = []): void;
}
