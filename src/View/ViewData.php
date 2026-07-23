<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use Countable;

/**
 * View Data.
 *
 * Represents the page-specific data supplied to a View.
 *
 * A ViewData instance is immutable and acts as the
 * transport object between the application layer and
 * the presentation layer.
 *
 * Unlike ViewContext, ViewData contains only the data
 * required to render a single view.
 */
final class ViewData implements Countable
{
    /**
     * View variables.
     *
     * @var array<string, mixed>
     */
    private array $values;

    /**
     * Create a new ViewData instance.
     *
     * @param array<string, mixed> $values
     */
    public function __construct(
        array $values = []
    ) {
        $this->values = $values;
    }

    /**
     * Determine whether a value exists.
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
     * Retrieve a value.
     */
    public function get(
        string $key,
        mixed $default = null
    ): mixed {
        return $this->values[$key] ?? $default;
    }

    /**
     * Return all view data.
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->values;
    }

    /**
     * Determine whether the data collection is empty.
     */
    public function isEmpty(): bool
    {
        return empty($this->values);
    }

    /**
     * Return the number of values.
     */
    public function count(): int
    {
        return count($this->values);
    }
}