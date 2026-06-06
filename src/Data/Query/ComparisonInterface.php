<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Query;

use Waffle\Commons\Contracts\Data\Enum\Operator;

/**
 * A single, immutable filter predicate of the SQR (RFC-022 §3.1): a field, an
 * operator, and the value(s) the field is compared against.
 *
 * Values are always exposed as a list so set operators (IN / NOT IN) and scalar
 * operators share one representation. A compiler maps every entry to a bound
 * parameter — implementations MUST never let these values be interpolated into
 * query text, which is what keeps the SQR injection-safe by construction.
 */
interface ComparisonInterface
{
    /** The field (column, document key, attribute) the predicate targets. */
    public string $field { get; }

    /** The comparison operator applied to the field. */
    public Operator $operator { get; }

    /**
     * The operand list: exactly one entry for scalar operators, one or more for
     * set operators.
     *
     * @var list<int|float|string|bool|null>
     */
    public array $values { get; }
}
