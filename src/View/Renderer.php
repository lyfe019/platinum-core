<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use Platinum\Core\View\Contracts\RendererInterface;

/**
 * Framework View Renderer.
 *
 * Coordinates the rendering pipeline for framework
 * views.
 *
 * The renderer transforms an immutable View into an
 * immutable RenderResult.
 *
 * The renderer is presentation-framework agnostic.
 * It performs no WordPress integration and does not
 * directly locate templates or layouts.
 *
 * Those responsibilities belong to dedicated
 * collaborators introduced in later phases.
 */
final class Renderer implements RendererInterface
{
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
        | Resolve Template
        |--------------------------------------------------------------------------
        |
        | Template resolution will be delegated to the ViewFinder
        | in a later phase. For now we construct a resolved template
        | directly from the logical template name.
        |
        */

        $template = new Template(
            $view->template(),
            $view->template(),
        );

        /*
        |--------------------------------------------------------------------------
        | Resolve Layout
        |--------------------------------------------------------------------------
        |
        | Layout resolution will become configurable once the
        | Layout Manager and Theme Bridge are introduced.
        |
        */

        $layout = new Layout(
            'default',
            'default',
        );

        /*
        |--------------------------------------------------------------------------
        | Render View
        |--------------------------------------------------------------------------
        |
        | Actual template rendering will be implemented in a
        | subsequent phase. For now, the renderer produces an
        | empty render result while preserving all rendering
        | metadata.
        |
        */

        return new RenderResult(
            content: '',
            template: $template,
            layout: $layout,
            context: $view->context(),
        );
    }
}