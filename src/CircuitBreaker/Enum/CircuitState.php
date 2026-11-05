<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\CircuitBreaker\Enum;

/**
 * The state of a circuit breaker ([NET-03], RFC-024 §3.2).
 */
enum CircuitState: string
{
    case Closed = 'closed';
    case HalfOpen = 'half_open';
    case Open = 'open';
}
