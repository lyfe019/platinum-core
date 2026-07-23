<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Immutable View Template.
 *
 * Represents a resolved template within the
 * framework View Engine.
 *
 * A Template describes the logical template name
 * together with the resolved file that will be
 * rendered.
 *
 * Template resolution is performed by the
 * ViewFinder. The Template itself performs no
 * rendering or filesystem operations.
 */
final class Template
{
    /**
     * Logical template name.
     *
     * Example:
     * customer.profile
     */
    private string $name;

    /**
     * Resolved template file.
     */
    private string $path;

    /**
     * Create a new template.
     */
    public function __construct(
        string $name,
        string $path,
    ) {
        $this->name = $name;
        $this->path = $path;
    }

    /**
     * Return the template name.
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
     * Determine whether the template has
     * a resolved path.
     */
    public function isResolved(): bool
    {
        return $this->path !== '';
    }

    /**
     * Determine whether the template matches
     * the supplied logical name.
     */
    public function is(
        string $name
    ): bool {
        return $this->name === $name;
    }
}