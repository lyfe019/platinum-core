<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Immutable View Layout.
 *
 * Represents a resolved layout within the
 * framework View Engine.
 *
 * A Layout describes the logical layout name
 * together with the resolved layout file that
 * will be used during rendering.
 *
 * Layout resolution is performed by the
 * ViewFinder. The Layout itself performs no
 * rendering or filesystem operations.
 */
final class Layout
{
    /**
     * Logical layout name.
     *
     * Examples:
     * default
     * admin
     * guest
     */
    private string $name;

    /**
     * Resolved layout file.
     */
    private string $path;

    /**
     * Create a new layout.
     */
    public function __construct(
        string $name,
        string $path,
    ) {
        $this->name = $name;
        $this->path = $path;
    }

    /**
     * Return the layout name.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Return the resolved layout path.
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * Determine whether the layout has
     * been resolved.
     */
    public function isResolved(): bool
    {
        return $this->path !== '';
    }

    /**
     * Determine whether this layout matches
     * the supplied logical name.
     */
    public function is(
        string $name
    ): bool {
        return $this->name === $name;
    }
}