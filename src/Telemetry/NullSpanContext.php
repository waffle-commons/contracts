<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry;

/**
 * The invalid, all-zero span context returned when no span is active (the no-op
 * tracing default): {@see self::isValid()} is always false and
 * {@see self::toTraceparent()} yields the canonical invalid W3C value, so
 * propagation writes nothing usable.
 */
final class NullSpanContext implements SpanContextInterface
{
    private const string INVALID_TRACE_ID = '00000000000000000000000000000000';
    private const string INVALID_SPAN_ID = '0000000000000000';

    #[\Override]
    public function traceId(): string
    {
        return self::INVALID_TRACE_ID;
    }

    #[\Override]
    public function spanId(): string
    {
        return self::INVALID_SPAN_ID;
    }

    #[\Override]
    public function traceFlags(): int
    {
        return 0;
    }

    #[\Override]
    public function traceState(): string
    {
        return '';
    }

    #[\Override]
    public function isValid(): bool
    {
        return false;
    }

    #[\Override]
    public function toTraceparent(): string
    {
        return '00-' . self::INVALID_TRACE_ID . '-' . self::INVALID_SPAN_ID . '-00';
    }
}
