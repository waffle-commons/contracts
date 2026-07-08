<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry;

use Throwable;
use Waffle\Commons\Contracts\Telemetry\Enum\SpanStatus;

/**
 * Inert span used when no tracing SDK is bound: every mutator is a no-op, so
 * instrumentation sprinkled through the core costs next to nothing by default.
 */
final class NullSpan implements SpanInterface
{
    #[\Override]
    public function setAttribute(string $key, string|int|float|bool $value): void
    {
        // no-op: the null tracer discards span data.
    }

    #[\Override]
    public function recordException(Throwable $exception): void
    {
        // no-op: the null tracer discards span data.
    }

    #[\Override]
    public function setStatus(SpanStatus $status): void
    {
        // no-op: the null tracer discards span data.
    }

    #[\Override]
    public function context(): SpanContextInterface
    {
        return new NullSpanContext();
    }

    #[\Override]
    public function end(): void
    {
        // no-op: nothing to flush.
    }
}
