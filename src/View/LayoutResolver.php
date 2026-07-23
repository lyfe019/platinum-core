<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Layout Resolver.
 *
 * Resolves logical layout names into concrete layout
 * files by searching an ordered collection of view
 * locations.
 *
 * Like the TemplateResolver, this class is completely
 * presentation-agnostic. It simply locates layouts.
 */
final class LayoutResolver
{
    /**
     * Resolve a layout.
     *
     * The first matching layout wins.
     *
     * @param array<int, ViewLocation> $locations
     *
     * @throws ViewException
     */
    public function resolve(
        ViewPath $path,
        array $locations
    ): Layout {

        foreach ($locations as $location) {

            $file = $location->resolve($path);

            if (is_file($file)) {
                return new Layout($file);
            }
        }

        throw new ViewException(
            sprintf(
                'Unable to resolve layout [%s].',
                $path->name()
            )
        );
    }
}