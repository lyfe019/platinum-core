<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Layout Engine.
 *
 * Coordinates layout composition for the framework's
 * presentation subsystem.
 *
 * The LayoutEngine is responsible for assembling the
 * final HTML document from:
 *
 * • Layout
 * • Template
 * • Sections
 * • Partials
 *
 * The LayoutEngine deliberately performs no template
 * discovery and no PHP execution itself.
 *
 * Those responsibilities belong to the ViewFinder
 * and TemplateEngine respectively.
 *
 * Rendering Flow
 *
 * ResolvedView
 *        │
 *        ▼
 * TemplateEngine
 *        │
 *        ▼
 * SectionManager
 *        │
 *        ▼
 * TemplateEngine (Layout)
 *        │
 *        ▼
 * Final HTML
 */
final class LayoutEngine
{
    /**
     * Create a new layout engine.
     */
    public function __construct(
        private TemplateEngine $templates,
        private SectionManager $sections,
        private PartialRenderer $partials,
    ) {
    }

    /**
     * Render a resolved view.
     *
     * @throws ViewException
     */
    public function render(
        ResolvedView $view
    ): string {

        /*
        |--------------------------------------------------------------------------
        | Render the page template.
        |--------------------------------------------------------------------------
        |
        | Executing the page template allows it to define
        | sections which are collected by the
        | SectionManager.
        |
        */

        $this->templates->render(
            $view->template()->path(),
            $view->view()->data()->all(),
        );

        /*
        |--------------------------------------------------------------------------
        | Render the layout.
        |--------------------------------------------------------------------------
        |
        | The layout retrieves sections through the
        | SectionManager.
        |
        */

        return $this->templates->render(
            $view->layout()->path(),
            [
                'sections' => $this->sections,
                'partials' => $this->partials,
                'context'  => $view->view()->context(),
                'view'     => $view->view(),
            ],
        );
    }

    /**
     * Return the section manager.
     */
    public function sections(): SectionManager
    {
        return $this->sections;
    }

    /**
     * Return the partial renderer.
     */
    public function partials(): PartialRenderer
    {
        return $this->partials;
    }
}