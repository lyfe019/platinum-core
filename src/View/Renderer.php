<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use Platinum\Core\View\Contracts\RendererInterface;

/**
 * Framework View Renderer.
 *
 * Coordinates the framework rendering pipeline.
 *
 * The renderer performs no template discovery,
 * layout resolution or presentation-specific
 * rendering itself.
 *
 * Its responsibility is to orchestrate the
 * rendering collaborators.
 *
 * Rendering flow:
 *
 * View
 *      ↓
 * ViewFinder
 *      ↓
 * ResolvedView
 *      ↓
 * ThemeContext
 *      ↓
 * ThemeBridge
 *      ↓
 * RenderResult
 */
final class Renderer implements RendererInterface
{
    /**
     * Create a new renderer.
     */
    public function __construct(
        private ViewFinder $finder,
        private ThemeBridge $themeBridge,
        private AssetManager $assets,
    ) {
    }

    /**
     * Render a framework view.
     *
     * @throws ViewException
     */
    public function render(
        View $view
    ): RenderResult {

        /*
        |--------------------------------------------------------------------------
        | Resolve View
        |--------------------------------------------------------------------------
        */

        $resolvedView = $this->finder->find(
            $view
        );

        /*
        |--------------------------------------------------------------------------
        | Build Theme Context
        |--------------------------------------------------------------------------
        |
        | The ThemeContext becomes the presentation
        | boundary passed to the ThemeBridge.
        |
        */

        $context = new ThemeContext(
            view: $view,
            resolvedView: $resolvedView,
            assets: $this->assets,
            metadata: [],
        );

        /*
        |--------------------------------------------------------------------------
        | Delegate Rendering
        |--------------------------------------------------------------------------
        */

        return $this->themeBridge->render(
            $context
        );
    }
}