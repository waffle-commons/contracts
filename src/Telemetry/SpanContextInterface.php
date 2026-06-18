<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry;

/**
 * The immutable W3C Trace Context identity of a span — trace id, span id, flags
 * and `tracestate`. Used to correlate spans within a trace and to serialise the
 * `traceparent` header on outbound calls so a trace can span service boundaries.
 */
interface SpanContextInterface
{
    /** Lowercase 32-hex-char trace id (16 bytes); the all-zero id when invalid. */
    public function traceId(): string;

    /** Lowercase 16-hex-char span id (8 bytes); the all-zero id when invalid. */
    public function spanId(): string;

    /** The W3C trace-flags byte (bit 0 = sampled). */
    public function traceFlags(): int;

    /** The opaque W3C `tracestate` vendor list (may be empty). */
    public function traceState(): string;

    /** True when this context carries a usable (non-zero) trace id and span id. */
    public function isValid(): bool;

    /** Serialise to a W3C `traceparent` value: `00-<trace>-<span>-<flags>`. */
    public function toTraceparent(): string;
}
