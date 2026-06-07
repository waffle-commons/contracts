<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Mapper;

/**
 * Pure Data Mapper between an immutable entity Value Object and its flat storage
 * representation (RFC-022 §5, write side).
 *
 * The mapper is the inverse of the read-side hydrator: it never mutates the
 * entity and holds no per-call state, so one instance is safe to share across a
 * FrankenPHP resident worker. Keeping the mapping here — not on the entity —
 * is what lets entities stay pure `readonly` DTOs (no Active Record).
 *
 * @template T of object
 */
interface DataMapperInterface
{
    /**
     * The backend target the entity persists to: a relational table, a document
     * collection, a key-value prefix, or an API endpoint identifier.
     */
    public function target(): string;

    /**
     * The name of the identity field within the mapped row (default `id`) — used
     * to build `findById` lookups and `UPDATE`/`DELETE` predicates.
     */
    public function identityField(): string;

    /**
     * The projection list (RFC-022 §3.1): every field the entity hydrates from,
     * i.e. the keys {@see self::toRow()} produces. Backends whose `findById`
     * needs an explicit projection (e.g. GraphQL) read it from here; backends
     * that can select all columns may ignore it.
     *
     * @return list<string>
     */
    public function fields(): array;

    /**
     * Extract the entity's identity, or null when it has none yet (which makes
     * {@see \Waffle\Commons\Contracts\Data\Repository\WritableRepositoryInterface::save()}
     * perform an INSERT rather than an UPDATE).
     *
     * @param T $entity
     */
    public function identify(object $entity): int|string|null;

    /**
     * Flatten the entity into a storage row of bound-parameter-safe scalars.
     * The returned map MUST contain only values a driver can bind directly —
     * never nested objects or resources.
     *
     * @param T $entity
     *
     * @return array<string, int|float|string|bool|null>
     */
    public function toRow(object $entity): array;
}
