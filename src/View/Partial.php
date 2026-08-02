<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * View Partial.
 *
 * Represents a reusable template fragment.
 *
 * A Partial is a small, independently renderable
 * template that can be included from another
 * template or layout.
 *
 * Examples:
 *
 * - partials/header
 * - partials/footer
 * - partials/sidebar
 * * The Partial object contains no rendering logic.
 * Rendering is delegated to the PartialRenderer.
 *
 * The object is immutable.
 */
final class Partial
{
    /**
     * Logical partial name.
     */
    private string $name;

    /**
     * Resolved template path.
     */
    private string $path;

    /**
     * Data available to the partial.
     *
     * @var array<string,mixed>
     */
    private array $data;

    /**
     * Create a new partial.
     *
     * @param array<string,mixed> $data
     */
    public function __construct(
        string $name,
        string $path,
        array $data = [],
    ) {
        $this->name = trim($name);
        $this->path = $path;
        $this->data = $data;
    }

    /**
     * Return the logical partial name.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Return the resolved template path.
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * Return the partial data.
     *
     * @return array<string,mixed>
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Determine whether the partial has data.
     */
    public function hasData(): bool
    {
        return $this->data !== [];
    }

    /**
     * Determine whether a data item exists.
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Return a data item.
     */
    public function get(
        string $key,
        mixed $default = null,
    ): mixed {
        return $this->data[$key] ?? $default;
    }
}