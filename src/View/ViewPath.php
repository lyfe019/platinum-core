<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Logical View Path.
 *
 * Represents the logical name of a view within the
 * framework.
 *
 * Examples:
 *
 * customer.profile
 * proposal.summary
 * engineering.design.report
 *
 * The ViewPath is intentionally independent of the
 * underlying filesystem. It simply describes the
 * logical location of a view.
 */
final class ViewPath
{
    /**
     * Logical view name.
     */
    private string $name;

    /**
     * Create a new view path.
     *
     * @throws ViewException
     */
    public function __construct(string $name)
    {
        $name = trim($name);

        if ($name === '') {
            throw new ViewException(
                'View path cannot be empty.'
            );
        }

        if (
            ! preg_match(
                '/^[A-Za-z0-9._-]+$/',
                $name
            )
        ) {
            throw new ViewException(
                sprintf(
                    'Invalid view path [%s].',
                    $name
                )
            );
        }

        $this->name = $name;
    }

    /**
     * Return the logical view name.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Convert the logical view into a relative
     * template path.
     *
     * Example:
     *
     * customer.profile
     *
     * becomes
     *
     * customer/profile.php
     */
    public function relativePath(): string
    {
        return str_replace(
            '.',
            DIRECTORY_SEPARATOR,
            $this->name
        ) . '.php';
    }

    /**
     * Determine whether two view paths are equal.
     */
    public function equals(
        self $other
    ): bool {
        return $this->name === $other->name;
    }

    /**
     * Return the logical name.
     */
    public function __toString(): string
    {
        return $this->name;
    }
}