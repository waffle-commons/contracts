<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry;

/**
 * Injects and extracts W3C Trace Context across a string-map carrier (typically
 * HTTP headers), so a trace continues across service boundaries. The HTTP client
 * injects on outbound calls; an inbound middleware extracts to parent the request
 * root span. The concrete W3C propagator ships with `waffle-commons/telemetry-otel`.
 */
interface TextMapPropagatorInterface
{
    /**
     * Write the propagation entries (`traceparent`, and `tracestate` when present)
     * for $context into $carrier.
     *
     * @param array<string, string> $carrier
     * @param-out array<string, string> $carrier
     */
    public function inject(SpanContextInterface $context, array &$carrier): void;

    /**
     * Read the parent span context from $carrier, or null when absent or invalid.
     *
     * @param array<string, string> $carrier
     */
    public function extract(array $carrier): ?SpanContextInterface;
}
