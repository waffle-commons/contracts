<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry\Enum;

/**
 * Terminal status of a span, mirroring the OpenTelemetry status code. `Unset` is
 * the default; set `Error` after a failure so backends can flag the span.
 */
enum SpanStatus: string
{
    case Unset = 'unset';
    case Ok = 'ok';
    case Error = 'error';
}
