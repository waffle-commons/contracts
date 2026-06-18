<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry;

use Waffle\Commons\Contracts\Telemetry\Enum\SpanKind;

/**
 * Starts spans and exposes the active context for propagation. The framework
 * core depends ONLY on this contract: the default {@see NullTracer} adds ~zero
 * overhead, and the real OpenTelemetry binding ships in
 * `waffle-commons/telemetry-otel` (the SDK never enters the core perimeter).
 *
 * Implementations that hold the active-context stack are request-scoped and MUST
 * be resettable between worker requests (FrankenPHP statelessness mandate).
 */
interface TracerInterface
{
    /**
     * Start and activate a new span. The caller owns the returned span and MUST
     * end it. When $parent is null the current active context (if any) is used as
     * the parent, otherwise the span starts a new root.
     */
    public function startSpan(
        string $name,
        SpanKind $kind = SpanKind::Internal,
        ?SpanContextInterface $parent = null,
    ): SpanInterface;

    /** The currently-active span context, or null when no span is active. */
    public function currentContext(): ?SpanContextInterface;
}
