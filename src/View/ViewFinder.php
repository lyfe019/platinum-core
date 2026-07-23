<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * View Finder.
 *
 * Coordinates template and layout resolution for
 * the framework View subsystem.
 *
 * The renderer depends only on this class rather
 * than interacting directly with the individual
 * resolvers.
 */
final class ViewFinder
{
    /**
     * Create a new view finder.
     *
     * @param array<int, ViewLocation> $locations
     */
    public function __construct(
        private TemplateResolver $templateResolver,
        private LayoutResolver $layoutResolver,
        private array $locations = [],
    ) {
    }

    /**
     * Resolve a template.
     *
     * @throws ViewException
     */
    public function template(
        ViewPath $path
    ): Template {

        return $this->templateResolver->resolve(
            $path,
            $this->locations,
        );
    }

    /**
     * Resolve a layout.
     *
     * @throws ViewException
     */
    public function layout(
        ViewPath $path
    ): Layout {

        return $this->layoutResolver->resolve(
            $path,
            $this->locations,
        );
    }

    /**
     * Return all registered locations.
     *
     * @return array<int, ViewLocation>
     */
    public function locations(): array
    {
        return $this->locations;
    }

    /**
     * Register an additional search location.
     */
    public function addLocation(
        ViewLocation $location
    ): void {

        $this->locations[] = $location;
    }
}