<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry;

use Waffle\Commons\Contracts\Telemetry\Enum\SpanKind;

/**
 * The default tracer: every span is a {@see NullSpan} and no context is ever
 * active, so tracing is effectively free until the OpenTelemetry binding in
 * `waffle-commons/telemetry-otel` is wired in.
 */
final class NullTracer implements TracerInterface
{
    #[\Override]
    public function startSpan(
        string $name,
        SpanKind $kind = SpanKind::Internal,
        ?SpanContextInterface $parent = null,
    ): SpanInterface {
        return new NullSpan();
    }

    #[\Override]
    public function currentContext(): ?SpanContextInterface
    {
        return null;
    }
}
