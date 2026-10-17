<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Health\Enum;

/**
 * The state a probe reports ([OPS-01]): binary, by decision (RFC-023 §5.4).
 */
enum HealthStatus: string
{
    case Up = 'up';
    case Down = 'down';
}
