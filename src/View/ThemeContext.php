<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Theme Context.
 *
 * Represents everything required by the presentation
 * layer to render a response.
 *
 * The ThemeContext is the boundary between the
 * framework's View subsystem and a presentation
 * implementation (such as WordPress).
 *
 * It aggregates:
 *
 * • View
 * • ResolvedView
 * • ViewContext
 * • AssetManager
 * • Presentation metadata
 *
 * ThemeContext deliberately contains no rendering
 * logic and knows nothing about WordPress.
 *
 * The object is immutable.
 */
final class ThemeContext
{
    /**
     * Logical framework view.
     */
    private View $view;

    /**
     * Fully resolved view.
     */
    private ResolvedView $resolvedView;

    /**
     * View context.
     */
    private ViewContext $context;

    /**
     * Asset manager.
     */
    private AssetManager $assets;

    /**
     * Presentation metadata.
     *
     * Examples:
     *
     * - title
     * - description
     * - canonical
     * - locale
     * - bodyClass
     * - robots
     *
     * @var array<string,mixed>
     */
    private array $metadata;

    /**
     * Create a new theme context.
     *
     * @param array<string,mixed> $metadata
     */
    public function __construct(
        View $view,
        ResolvedView $resolvedView,
        ViewContext $context,
        AssetManager $assets,
        array $metadata = [],
    ) {
        $this->view = $view;
        $this->resolvedView = $resolvedView;
        $this->context = $context;
        $this->assets = $assets;
        $this->metadata = $metadata;
    }

    /**
     * Return the logical view.
     */
    public function view(): View
    {
        return $this->view;
    }

    /**
     * Return the resolved view.
     */
    public function resolvedView(): ResolvedView
    {
        return $this->resolvedView;
    }

    /**
     * Return the view context.
     */
    public function context(): ViewContext
    {
        return $this->context;
    }

    /**
     * Return the asset manager.
     */
    public function assets(): AssetManager
    {
        return $this->assets;
    }

    /**
     * Return all presentation metadata.
     *
     * @return array<string,mixed>
     */
    public function metadata(): array
    {
        return $this->metadata;
    }

    /**
     * Determine whether metadata exists.
     */
    public function hasMetadata(
        string $key
    ): bool {
        return array_key_exists(
            $key,
            $this->metadata
        );
    }

    /**
     * Return a metadata value.
     */
    public function metadataValue(
        string $key,
        mixed $default = null,
    ): mixed {
        return $this->metadata[$key] ?? $default;
    }
}