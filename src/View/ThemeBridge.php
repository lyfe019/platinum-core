<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Theme Bridge.
 *
 * Defines the contract between the framework's View
 * subsystem and a presentation environment.
 *
 * A ThemeBridge receives a fully prepared ThemeContext
 * and renders it using the host platform.
 *
 * Implementations may target:
 *
 * • WordPress
 * • Blade
 * • Twig
 * • React SSR
 * • Console
 *
 * The View subsystem depends only on this abstraction.
 */
interface ThemeBridge
{
    /**
     * Render the supplied theme context.
     */
    public function render(
        ThemeContext $context
    ): RenderResult;

    /**
     * Share presentation data across every rendered
     * view.
     */
    public function share(
        string $key,
        mixed $value
    ): void;

    /**
     * Return the shared presentation data.
     *
     * @return array<string,mixed>
     */
    public function shared(): array;
}