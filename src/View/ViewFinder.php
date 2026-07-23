<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Framework View Finder.
 *
 * Coordinates the process of resolving a logical
 * framework View into a fully resolved rendering
 * definition.
 *
 * The ViewFinder delegates template and layout
 * resolution to dedicated collaborators and
 * returns an immutable ResolvedView.
 *
 * The renderer does not perform any resolution
 * itself—it simply consumes the ResolvedView.
 */
final class ViewFinder
{
    /**
     * Create a new view finder.
     */
    public function __construct(
        private TemplateResolver $templateResolver,
        private LayoutResolver $layoutResolver,
    ) {
    }

    /**
     * Resolve a framework view.
     *
     * @throws ViewException
     */
    public function find(
        View $view
    ): ResolvedView {

        $template = $this->templateResolver
            ->resolve(
                $view->template()
            );

        $layout = $this->layoutResolver
            ->resolve(
                $view->layout()
            );

        return new ResolvedView(
            $template,
            $layout,
        );
    }
}