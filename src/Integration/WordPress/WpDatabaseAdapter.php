<?php

declare(strict_types=1);

namespace Platinum\Core\Integration\WordPress;

use Platinum\Core\Persistence\Contracts\DatabaseAdapter;
use Platinum\Core\Persistence\Contracts\DatabaseException;
use RuntimeException;

/**
 * WordPress Database Adapter.
 *
 * Adapts the framework database contract to the
 * WordPress database layer.
 *
 * This is the only persistence component within the
 * framework that knows about the WordPress database
 * abstraction.
 */
final class WpDatabaseAdapter implements DatabaseAdapter
{
    /**
     * WordPress database instance.
     */
    private \wpdb $database;

    /**
     * Create a new database adapter.
     */
    public function __construct()
    {
        global $wpdb;

        if (! $wpdb instanceof \wpdb) {
            throw new RuntimeException(
                'The WordPress database connection is unavailable.'
            );
        }

        $this->database = $wpdb;
    }

    /**
     * Execute a query returning multiple rows.
     *
     * @return array<int, array<string, mixed>>
     */
    public function select(
        string $query,
        array $bindings = []
    ): array {

        if ($bindings !== []) {
            $query = $this->database->prepare(
                $query,
                ...$bindings
            );
        }

        return $this->database->get_results(
            $query,
            ARRAY_A
        );
    }

    /**
     * Execute a query returning a single row.
     *
     * @return array<string, mixed>|null
     */
    public function first(
        string $query,
        array $bindings = []
    ): ?array {

        if ($bindings !== []) {
            $query = $this->database->prepare(
                $query,
                ...$bindings
            );
        }

        $result = $this->database->get_row(
            $query,
            ARRAY_A
        );

        return $result ?: null;
    }

    /**
     * Insert a new record.
     */
    public function insert(
        string $table,
        array $values
    ): bool {

        if (
            $this->database->insert(
                $table,
                $values
            ) === false
        ) {
            throw new DatabaseException(
                $this->database->last_error
            );
        }

        return true;
    }

    /**
     * Update existing records.
     */
    public function update(
        string $table,
        array $values,
        array $where
    ): bool {

        if (
            $this->database->update(
                $table,
                $values,
                $where
            ) === false
        ) {
            throw new DatabaseException(
                $this->database->last_error
            );
        }

        return true;
    }

    /**
     * Delete existing records.
     */
    public function delete(
        string $table,
        array $where
    ): bool {

        if (
            $this->database->delete(
                $table,
                $where
            ) === false
        ) {
            throw new DatabaseException(
                $this->database->last_error
            );
        }

        return true;
    }

    /**
     * Execute a database statement.
     */
    public function statement(
        string $query,
        array $bindings = []
    ): bool {

        if ($bindings !== []) {
            $query = $this->database->prepare(
                $query,
                ...$bindings
            );
        }

        if (
            $this->database->query(
                $query
            ) === false
        ) {
            throw new DatabaseException(
                $this->database->last_error
            );
        }

        return true;
    }

    /**
     * Begin a transaction.
     */
    public function beginTransaction(): void
    {
        if (
            $this->database->query(
                'START TRANSACTION'
            ) === false
        ) {
            throw new DatabaseException(
                $this->database->last_error
            );
        }
    }

    /**
     * Commit the active transaction.
     */
    public function commit(): void
    {
        if (
            $this->database->query(
                'COMMIT'
            ) === false
        ) {
            throw new DatabaseException(
                $this->database->last_error
            );
        }
    }

    /**
     * Roll back the active transaction.
     */
    public function rollBack(): void
    {
        if (
            $this->database->query(
                'ROLLBACK'
            ) === false
        ) {
            throw new DatabaseException(
                $this->database->last_error
            );
        }
    }
}