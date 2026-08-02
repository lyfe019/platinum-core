<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * PHP Renderer.
 *
 * Coordinates the PHP rendering pipeline.
 *
 * The PHPRenderer transforms a fully prepared
 * ThemeContext into HTML.
 *
 * It delegates template execution to the
 * TemplateEngine.
 *
 * Responsibilities:
 *
 * • Coordinate PHP rendering
 * • Execute the template engine
 * • Return rendered HTML
 *
 * The PHPRenderer deliberately performs no:
 *
 * • Template discovery
 * • Layout resolution
 * • WordPress integration
 * • View model construction
 */
final class PHPRenderer
{
    /**
     * Create a new PHP renderer.
     */
    public function __construct(
        private TemplateEngine $engine,
    ) {
    }

    /**
     * Render the supplied theme context.
     *
     * @throws ViewException
     */
    public function render(
        ThemeContext $context
    ): string {

        /*
        |--------------------------------------------------------------------------
        | Execute Template Engine
        |--------------------------------------------------------------------------
        |
        | The template engine performs the actual
        | PHP template execution.
        |
        */

        return $this->engine->render(
            $context
        );
    }
}