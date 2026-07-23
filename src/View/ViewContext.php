<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use Countable;

/**
 * View Context.
 *
 * Represents the shared presentation context available
 * during view rendering.
 *
 * Unlike ViewData, which contains data specific to a
 * single page, ViewContext contains application-wide
 * presentation state that is shared across all rendered
 * views.
 *
 * Examples include:
 *
 * - Authenticated user
 * - Navigation
 * - Current locale
 * - Flash messages
 * - Active theme
 * - Application metadata
 *
 * The ViewContext is immutable.
 */
final class ViewContext implements Countable
{
    /**
     * Shared context values.
     *
     * @var array<string,mixed>
     */
    private array $values;

    /**
     * Create a new view context.
     *
     * @param array<string,mixed> $values
     */
    public function __construct(
        array $values = []
    ) {
        $this->values = $values;
    }

    /**
     * Determine whether a context value exists.
     */
    public function has(
        string $key
    ): bool {
        return array_key_exists(
            $key,
            $this->values
        );
    }

    /**
     * Return a context value.
     */
    public function get(
        string $key,
        mixed $default = null
    ): mixed {
        return $this->values[$key] ?? $default;
    }

    /**
     * Return the complete context.
     *
     * @return array<string,mixed>
     */
    public function all(): array
    {
        return $this->values;
    }

    /**
     * Determine whether the context is empty.
     */
    public function isEmpty(): bool
    {
        return empty($this->values);
    }

    /**
     * Return the number of context values.
     */
    public function count(): int
    {
        return count($this->values);
    }
}