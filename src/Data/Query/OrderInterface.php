<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Query;

use Waffle\Commons\Contracts\Data\Enum\Direction;

/**
 * An immutable SQR ordering clause (RFC-022 §3.1): a field paired with a sort
 * direction.
 */
interface OrderInterface
{
    /** The field the result set is ordered by. */
    public string $field { get; }

    /** The sort direction applied to the field. */
    public Direction $direction { get; }
}
