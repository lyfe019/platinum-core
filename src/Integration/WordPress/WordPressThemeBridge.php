<?php

declare(strict_types=1);

namespace Platinum\Core\Integration\WordPress;

use Platinum\Core\View\RenderResult;
use Platinum\Core\View\ResolvedView;
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
 * The bridge intentionally performs no template
 * rendering itself. Rendering is delegated to a
 * renderer introduced in a later phase.
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
        | Before render.
        |--------------------------------------------------------------------------
        */

        do_action(
            ThemeHooks::BEFORE_RENDER,
            $context
        );

        /*
        |--------------------------------------------------------------------------
        | Retrieve resolved view.
        |--------------------------------------------------------------------------
        */

        $resolved = $context->resolvedView();

        /*
        |--------------------------------------------------------------------------
        | Rendering.
        |--------------------------------------------------------------------------
        |
        | A future PHPRenderer will receive:
        |
        | - Template
        | - Layout
        | - ViewContext
        |
        | and produce the final HTML.
        |
        */

        $output = '';

        /*
        |--------------------------------------------------------------------------
        | After render.
        |--------------------------------------------------------------------------
        */

        do_action(
            ThemeHooks::AFTER_RENDER,
            $context
        );

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