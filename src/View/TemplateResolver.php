<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Template Resolver.
 *
 * Resolves logical view names into concrete template
 * files by searching an ordered collection of view
 * locations.
 *
 * The resolver is presentation-agnostic. It does not
 * know about WordPress, themes, rendering engines or
 * layouts. It simply locates templates.
 */
final class TemplateResolver
{
    /**
     * Resolve a template.
     *
     * The first matching template wins.
     *
     * @param array<int, ViewLocation> $locations
     *
     * @throws ViewException
     */
    public function resolve(
        ViewPath $path,
        array $locations
    ): Template {

        foreach ($locations as $location) {

            $file = $location->resolve($path);

            if (is_file($file)) {
                return new Template($file);
            }
        }

        throw new ViewException(
            sprintf(
                'Unable to resolve view [%s].',
                $path->name()
            )
        );
    }
}