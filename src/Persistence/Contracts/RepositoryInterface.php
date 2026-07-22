<?php

declare(strict_types=1);

namespace Platinum\Core\Contracts;

/**
 * Repository Interface.
 *
 * Defines the common contract implemented by all
 * repositories throughout the framework.
 *
 * Repositories encapsulate persistence concerns,
 * allowing the domain layer to work entirely with
 * domain concepts rather than storage technologies.
 *
 * This interface is intentionally host-agnostic and
 * does not assume any particular database engine,
 * ORM, or storage implementation.
 */
interface RepositoryInterface
{
    /**
     * Determine whether an entity exists.
     */
    public function exists(
        string|int $id
    ): bool;

    /**
     * Retrieve an entity by its identifier.
     */
    public function find(
        string|int $id
    ): mixed;

    /**
     * Retrieve all entities.
     *
     * @return iterable<mixed>
     */
    public function all(): iterable;

    /**
     * Persist a new entity.
     */
    public function create(
        mixed $entity
    ): void;

    /**
     * Persist changes to an existing entity.
     */
    public function update(
        mixed $entity
    ): void;

    /**
     * Remove an entity.
     */
    public function delete(
        string|int $id
    ): void;
}