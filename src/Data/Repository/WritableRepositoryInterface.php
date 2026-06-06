<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Repository;

use Waffle\Commons\Contracts\Data\Mapper\DataMapperInterface;

/**
 * The stateless write surface of the Repository Layer (RFC-022 §3): adds the
 * CRUD mutations on top of the read-only {@see RepositoryInterface}.
 *
 * Writes go through a {@see DataMapperInterface} (pure Data Mapper pattern) —
 * the entity stays an immutable Value Object with no persistence behaviour of
 * its own. There is, by design, NO Active Record, NO Unit of Work, and NO
 * Identity Map: a writable repository keeps no entity state between calls, so a
 * single instance is safe to share across FrankenPHP resident-worker requests.
 *
 * Every backend failure MUST surface as a
 * {@see \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface}.
 *
 * @template T of object
 *
 * @extends RepositoryInterface<T>
 */
interface WritableRepositoryInterface extends RepositoryInterface
{
    /**
     * Persist an entity, choosing INSERT vs UPDATE by its mapped identity: a
     * null identity (see {@see DataMapperInterface::identify()}) inserts a new
     * record; a non-null identity updates (or upserts) the matching record.
     *
     * @param T $entity
     *
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When the backend write fails.
     */
    public function save(object $entity): void;

    /**
     * Delete the record identified by the entity's mapped identity. A no-op is
     * permitted when nothing matches; a backend failure MUST throw.
     *
     * @param T $entity
     *
     * @throws \InvalidArgumentException
     *         When the entity carries no identity to delete by.
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When the backend write fails.
     */
    public function delete(object $entity): void;

    /**
     * Fetch and hydrate the single record whose identity field equals `$id`, or
     * null when nothing matches.
     *
     * @return T|null
     *
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When the backend call fails.
     * @throws \Waffle\Commons\Contracts\Exception\Validation\ValidationExceptionInterface
     *         When the record cannot be hydrated onto the target DTO.
     */
    public function findById(int|string $id): ?object;
}
