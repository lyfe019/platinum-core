<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Variable Extractor.
 *
 * Converts a ThemeContext into the variables made
 * available to a rendered template.
 *
 * The extractor is responsible for preparing the
 * presentation data consumed by the rendering engine.
 *
 * It deliberately performs no rendering itself and
 * knows nothing about PHP templates or WordPress.
 *
 * Future versions may contribute:
 *
 * • Shared presentation data
 * • Global variables
 * • Authenticated user
 * • Navigation
 * • Flash messages
 * • Theme settings
 */
final class VariableExtractor
{
    /**
     * Extract template variables.
     *
     * The returned array is intended to be imported
     * into the template scope by the rendering engine.
     *
     * @return array<string,mixed>
     */
    public function extract(
        ThemeContext $context
    ): array {

        /*
        |--------------------------------------------------------------------------
        | View Data
        |--------------------------------------------------------------------------
        |
        | The ViewData object already represents the page-specific
        | variables prepared by the application layer.
        |
        */

        $variables = $context
            ->view()
            ->data()
            ->all();

        /*
        |--------------------------------------------------------------------------
        | Framework Objects
        |--------------------------------------------------------------------------
        |
        | Make the core presentation objects available to templates.
        | These provide advanced rendering capabilities without the
        | template needing to construct or resolve anything.
        |
        */

        $variables['view'] = $context->view();

        $variables['context'] = $context->context();

        $variables['resolvedView'] = $context->resolvedView();

        $variables['assets'] = $context->assets();

        $variables['metadata'] = $context->metadata();

        return $variables;
    }
}