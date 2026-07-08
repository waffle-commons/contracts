<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry\Enum;

/**
 * The relationship between a span and its parent/children, mirroring the
 * OpenTelemetry `SpanKind`. Drives how a backend renders the trace tree.
 */
enum SpanKind: string
{
    /** In-process work with no remote boundary (default). */
    case Internal = 'internal';
    /** Handling of an inbound request (the request root span). */
    case Server = 'server';
    /** An outbound call to a remote service (e.g. the HTTP client). */
    case Client = 'client';
    /** Producing a message onto a broker/queue. */
    case Producer = 'producer';
    /** Consuming a message from a broker/queue. */
    case Consumer = 'consumer';
}
