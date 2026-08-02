<?php

declare(strict_types=1);

namespace Platinum\Core\Integration\WordPress;

use Platinum\Core\View\PHPRenderer;
use Platinum\Core\View\RenderResult;
use Platinum\Core\View\ThemeBridge;
use Platinum\Core\View\ThemeContext;
use Platinum\Core\View\ThemeHooks;

/**
 * WordPress Theme Bridge.
 *
 * Adapts the Platinum View subsystem to the
 * active WordPress presentation environment.
 *
 * The bridge translates framework presentation
 * concepts into native WordPress behaviour.
 *
 * It does not perform rendering itself.
 * Rendering is delegated to the framework's
 * PHPRenderer.
 */
final class WordPressThemeBridge implements ThemeBridge
{
    /**
     * Shared presentation data.
     *
     * @var array<string,mixed>
     */
    private array $shared = [];

    /**
     * Create a new theme bridge.
     */
    public function __construct(
        private PHPRenderer $renderer,
    ) {
    }

    /**
     * Render the supplied theme context.
     */
    public function render(
        ThemeContext $context
    ): RenderResult {

        /*
        |--------------------------------------------------------------------------
        | Allow themes and plugins to enrich the
        | presentation context.
        |--------------------------------------------------------------------------
        */

        $context = apply_filters(
            ThemeHooks::VIEW_CONTEXT,
            $context
        );

        /*
        |--------------------------------------------------------------------------
        | Publish assets.
        |--------------------------------------------------------------------------
        */

        do_action(
            ThemeHooks::ASSETS,
            $context->assets()
        );

        /*
        |--------------------------------------------------------------------------
        | Before Render.
        |--------------------------------------------------------------------------
        */

        do_action(
            ThemeHooks::BEFORE_RENDER,
            $context
        );

        /*
        |--------------------------------------------------------------------------
        | Execute Framework Renderer.
        |--------------------------------------------------------------------------
        */

        $output = $this->renderer->render(
            $context
        );

        /*
        |--------------------------------------------------------------------------
        | After Render.
        |--------------------------------------------------------------------------
        */

        do_action(
            ThemeHooks::AFTER_RENDER,
            $context
        );

        /*
        |--------------------------------------------------------------------------
        | Return Render Result.
        |--------------------------------------------------------------------------
        */

        $resolved = $context->resolvedView();

        return new RenderResult(
            content: $output,
            template: $resolved->template(),
            layout: $resolved->layout(),
            context: $context->context(),
        );
    }

    /**
     * Share presentation data.
     */
    public function share(
        string $key,
        mixed $value
    ): void {
        $this->shared[$key] = $value;
    }

    /**
     * Return shared presentation data.
     *
     * @return array<string,mixed>
     */
    public function shared(): array
    {
        return $this->shared;
    }
}