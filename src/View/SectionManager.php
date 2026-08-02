<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use RuntimeException;

/**
 * Section Manager.
 *
 * Collects and manages named view sections during
 * template rendering.
 *
 * Sections are created while a template executes
 * and are later consumed by the LayoutEngine when
 * composing the final page.
 *
 * The manager owns the mutable rendering state,
 * while individual Section objects remain immutable.
 *
 * Responsibilities:
 *
 * - Start section capture
 * - End section capture
 * - Store rendered sections
 * - Retrieve sections
 * - Provide default section content
 *
 * The SectionManager deliberately knows nothing
 * about layouts, templates or WordPress.
 */
final class SectionManager
{
    /**
     * Registered sections.
     *
     * @var array<string,Section>
     */
    private array $sections = [];

    /**
     * Active section name.
     */
    private ?string $activeSection = null;

    /**
     * Begin capturing a section.
     *
     * @throws RuntimeException
     */
    public function start(string $name): void
    {
        if ($this->activeSection !== null) {
            throw new RuntimeException(
                sprintf(
                    'Cannot start section "%s" while section "%s" is active.',
                    $name,
                    $this->activeSection
                )
            );
        }

        $this->activeSection = trim($name);

        ob_start();
    }

    /**
     * Finish the active section.
     *
     * @throws RuntimeException
     */
    public function end(): Section
    {
        if ($this->activeSection === null) {
            throw new RuntimeException(
                'No active section is currently being captured.'
            );
        }

        $content = (string) ob_get_clean();

        $section = new Section(
            $this->activeSection,
            $content,
        );

        $this->sections[$section->name()] = $section;

        $this->activeSection = null;

        return $section;
    }

    /**
     * Determine whether a section exists.
     */
    public function has(string $name): bool
    {
        return isset($this->sections[$name]);
    }

    /**
     * Retrieve a section.
     */
    public function get(string $name): ?Section
    {
        return $this->sections[$name] ?? null;
    }

    /**
     * Retrieve rendered section content.
     */
    public function content(
        string $name,
        string $default = '',
    ): string {
        return $this->sections[$name]?->content() ?? $default;
    }

    /**
     * Register or replace a section.
     */
    public function put(Section $section): void
    {
        $this->sections[$section->name()] = $section;
    }

    /**
     * Remove a section.
     */
    public function forget(string $name): void
    {
        unset($this->sections[$name]);
    }

    /**
     * Remove all registered sections.
     */
    public function clear(): void
    {
        $this->sections = [];
        $this->activeSection = null;
    }

    /**
     * Determine whether a section is currently
     * being captured.
     */
    public function capturing(): bool
    {
        return $this->activeSection !== null;
    }

    /**
     * Return the active section name.
     */
    public function active(): ?string
    {
        return $this->activeSection;
    }

    /**
     * Return all registered sections.
     *
     * @return array<string,Section>
     */
    public function all(): array
    {
        return $this->sections;
    }
}