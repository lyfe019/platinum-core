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
 *   ↓
 * ViewFinder
 *   ↓
 * ResolvedView
 *   ↓
 * ThemeBridge
 *   ↓
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
        | Resolve the logical view.
        |--------------------------------------------------------------------------
        */

        $resolvedView = $this->finder->find(
            $view
        );

        /*
        |--------------------------------------------------------------------------
        | Delegate rendering.
        |--------------------------------------------------------------------------
        */

        return $this->themeBridge->render(
            $resolvedView,
            $view
        );
    }
}