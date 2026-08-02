<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * View Section.
 *
 * Represents a named section of rendered content.
 *
 * Sections are collected during template execution
 * and later injected into a layout by the
 * LayoutEngine.
 *
 * Examples:
 *
 * - content
 * - sidebar
 * - scripts
 * - styles
 * - hero
 * * The object is immutable.
 */
final class Section
{
    /**
     * Section name.
     */
    private string $name;

    /**
     * Rendered section content.
     */
    private string $content;

    /**
     * Create a new section.
     */
    public function __construct(
        string $name,
        string $content,
    ) {
        $this->name = trim($name);
        $this->content = $content;
    }

    /**
     * Return the section name.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Return the rendered content.
     */
    public function content(): string
    {
        return $this->content;
    }

    /**
     * Determine whether this section is empty.
     */
    public function isEmpty(): bool
    {
        return trim($this->content) === '';
    }

    /**
     * Convert the section to a string.
     */
    public function __toString(): string
    {
        return $this->content;
    }
}