<?php

declare(strict_types=1);

namespace Platinum\Core\Persistence\Contracts;

/**
 * Database Adapter Contract.
 *
 * Defines the persistence capabilities required by the
 * framework independently of any database engine or host
 * environment.
 *
 * Implementations may target WordPress, PDO, SQLite,
 * PostgreSQL, SQL Server, or any other storage engine.
 */
interface DatabaseAdapter
{
    /**
     * Execute a query returning multiple rows.
     *
     * @return array<int, array<string, mixed>>
     */
    public function select(
        string $query,
        array $bindings = []
    ): array;

    /**
     * Execute a query returning a single row.
     *
     * @return array<string, mixed>|null
     */
    public function first(
        string $query,
        array $bindings = []
    ): ?array;

    /**
     * Insert a new record.
     */
    public function insert(
        string $table,
        array $values
    ): bool;

    /**
     * Update existing records.
     */
    public function update(
        string $table,
        array $values,
        array $where
    ): bool;

    /**
     * Delete existing records.
     */
    public function delete(
        string $table,
        array $where
    ): bool;

    /**
     * Execute a database statement.
     */
    public function statement(
        string $query,
        array $bindings = []
    ): bool;

    /**
     * Begin a database transaction.
     */
    public function beginTransaction(): void;

    /**
     * Commit the active transaction.
     */
    public function commit(): void;

    /**
     * Roll back the active transaction.
     */
    public function rollBack(): void;
}