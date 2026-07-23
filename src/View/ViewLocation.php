<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * View Location.
 *
 * Represents a root directory that may contain
 * templates and layouts.
 *
 * A ViewLocation does not know who owns the
 * directory. It simply represents a searchable
 * location within the framework.
 */
final class ViewLocation
{
    /**
     * Root directory.
     */
    private string $directory;

    /**
     * Create a new view location.
     *
     * @throws ViewException
     */
    public function __construct(
        string $directory
    ) {
        $directory = rtrim(
            trim($directory),
            DIRECTORY_SEPARATOR
        );

        if ($directory === '') {
            throw new ViewException(
                'View location cannot be empty.'
            );
        }

        $this->directory = $directory;
    }

    /**
     * Return the root directory.
     */
    public function directory(): string
    {
        return $this->directory;
    }

    /**
     * Determine whether the location exists.
     */
    public function exists(): bool
    {
        return is_dir(
            $this->directory
        );
    }

    /**
     * Build an absolute template path from a
     * logical ViewPath.
     */
    public function resolve(
        ViewPath $path
    ): string {
        return $this->directory
            . DIRECTORY_SEPARATOR
            . $path->relativePath();
    }

    /**
     * Determine whether two locations are equal.
     */
    public function equals(
        self $other
    ): bool {
        return $this->directory === $other->directory();
    }

    /**
     * Return the directory.
     */
    public function __toString(): string
    {
        return $this->directory;
    }
}