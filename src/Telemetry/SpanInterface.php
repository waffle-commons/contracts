<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry;

use Throwable;
use Waffle\Commons\Contracts\Telemetry\Enum\SpanStatus;

/**
 * A single timed unit of work within a trace. Open one with
 * {@see TracerInterface::startSpan()}, enrich it, then ALWAYS end it — the
 * idiom is `try { … } finally { $span->end(); }`.
 *
 * Implementations must be safe to use when no SDK is bound; the framework core
 * defaults to {@see NullSpan}, whose methods are inert (~zero overhead).
 */
interface SpanInterface
{
    /** Attach a typed attribute (OTel semantic-convention key, e.g. `http.route`). */
    public function setAttribute(string $key, string|int|float|bool $value): void;

    /** Record an exception against the span (does not end it). */
    public function recordException(Throwable $exception): void;

    /** Set the terminal status (e.g. {@see SpanStatus::Error} after a failure). */
    public function setStatus(SpanStatus $status): void;

    /** This span's W3C context — for propagation and for parenting child spans. */
    public function context(): SpanContextInterface;

    /** Close the span and hand it to the exporter pipeline. Idempotent. */
    public function end(): void;
}
