<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry\Metrics;

/**
 * The default metrics registry: records nothing. Used when no telemetry backend
 * is bound, so metric calls scattered through the core stay inert.
 */
final class NullMetricsRegistry implements MetricsRegistryInterface
{
    /** @param array<string, string> $labels */
    #[\Override]
    public function increment(string $name, float $value = 1.0, array $labels = []): void
    {
        // no-op: nothing is recorded.
    }

    /** @param array<string, string> $labels */
    #[\Override]
    public function observe(string $name, float $value, array $labels = []): void
    {
        // no-op: nothing is recorded.
    }

    /** @param array<string, string> $labels */
    #[\Override]
    public function gauge(string $name, float $value, array $labels = []): void
    {
        // no-op: nothing is recorded.
    }
}
