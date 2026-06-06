<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Repository;

use Generator;
use Waffle\Commons\Contracts\Data\Query\QueryInterface;

/**
 * Contract for the Stateless Repository Layer (RFC-022 §3).
 *
 * A repository translates an SQR {@see QueryInterface} into a backend call and
 * maps every returned record onto an immutable, `readonly` DTO. There is — by
 * design — no Active Record, no Unit of Work, and no Identity Map: a repository
 * keeps NO record state between calls, so it is safe to share across FrankenPHP
 * resident-worker requests.
 *
 * Hydration MUST go through constructor-driven mapping with PHP 8.5 Property
 * Hook validation (RFC-022 §5): a poisoned record surfaces as a
 * {@see \Waffle\Commons\Contracts\Exception\Validation\ValidationExceptionInterface},
 * never as a silently corrupt object. Every backend failure MUST surface as a
 * {@see \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface}.
 *
 * @template T of object
 */
interface RepositoryInterface
{
    /**
     * Execute the query and hydrate every matching record.
     *
     * @return list<T>
     *
     * @throws \InvalidArgumentException
     *         When the query cannot be represented on the implementing backend.
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When the backend call fails.
     * @throws \Waffle\Commons\Contracts\Exception\Validation\ValidationExceptionInterface
     *         When a record cannot be hydrated onto the target DTO.
     */
    public function find(QueryInterface $query): array;

    /**
     * Execute the query and hydrate the first matching record, or null when
     * nothing matches. Implementations SHOULD bound the backend call (limit 1)
     * rather than discard rows client-side.
     *
     * @return T|null
     *
     * @throws \InvalidArgumentException
     *         When the query cannot be represented on the implementing backend.
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When the backend call fails.
     * @throws \Waffle\Commons\Contracts\Exception\Validation\ValidationExceptionInterface
     *         When the record cannot be hydrated onto the target DTO.
     */
    public function findOne(QueryInterface $query): ?object;

    /**
     * Execute the query and yield each hydrated record sequentially.
     *
     * This is the buffer-streaming path mandated by RFC-022 §4.1: backends with
     * cursor support MUST fetch row-by-row so a large result set never
     * materialises in memory at once ($O(1)$ row buffering); backends without
     * cursors MAY yield from an already-bounded page.
     *
     * @return Generator<int, T>
     *
     * @throws \InvalidArgumentException
     *         When the query cannot be represented on the implementing backend.
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When the backend call fails.
     * @throws \Waffle\Commons\Contracts\Exception\Validation\ValidationExceptionInterface
     *         When a record cannot be hydrated onto the target DTO.
     */
    public function stream(QueryInterface $query): Generator;
}
