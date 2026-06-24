<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\HttpClient\Enum;

/**
 * Settlement state of a {@see \Waffle\Commons\Contracts\HttpClient\PromiseInterface}.
 *
 * A promise starts {@see self::Pending} and transitions exactly once — to
 * {@see self::Fulfilled} when its response is available, or {@see self::Rejected}
 * when the underlying transfer failed. The transition is terminal.
 */
enum PromiseState: string
{
    case Pending = 'pending';
    case Fulfilled = 'fulfilled';
    case Rejected = 'rejected';
}
