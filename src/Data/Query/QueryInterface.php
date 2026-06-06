<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Query;

/**
 * The stateless Semantic Query Representation (SQR, RFC-022 §3.1): an immutable,
 * compiler-agnostic description of a read query — projection, source scope,
 * filter predicates, ordering, and bounded pagination.
 *
 * A query holds only *representation* state. It performs no I/O and knows
 * nothing about SQL, Firestore, or any other backend; driver compilers translate
 * it into the native payload of the selected engine. Implementations MUST be
 * immutable (copy-on-write builders) so an instance is safe to share across a
 * FrankenPHP resident worker without any mutable state.
 */
interface QueryInterface
{
    /**
     * The projection list; empty selects every field the backend returns.
     *
     * @var list<string>
     */
    public array $fields { get; }

    /** The source table (relational), collection (document), or root field (API). */
    public ?string $from { get; }

    /**
     * AND-combined filter predicates, in declaration order.
     *
     * @var list<ComparisonInterface>
     */
    public array $criteria { get; }

    /**
     * Ordering clauses, in declaration order.
     *
     * @var list<OrderInterface>
     */
    public array $orderings { get; }

    /** Bounded page size, or null when unbounded. */
    public ?int $limit { get; }

    /** Bounded page offset, or null when unset. */
    public ?int $offset { get; }
}
