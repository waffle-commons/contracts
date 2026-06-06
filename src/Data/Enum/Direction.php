<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Enum;

/**
 * Sort direction for an SQR ordering clause (RFC-022 §3.1). The backing value is
 * the canonical SQL keyword; non-relational compilers translate it (e.g. MongoDB
 * maps it to `1` / `-1`).
 */
enum Direction: string
{
    case Ascending = 'ASC';
    case Descending = 'DESC';
}
