<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Theme Hook Definitions.
 *
 * Defines every extension point exposed by the
 * Platinum View subsystem.
 *
 * These constants are host-independent.
 *
 * The framework never calls WordPress functions
 * directly from this class.
 *
 * Instead, host integrations (such as the
 * WordPress Theme Bridge) translate these
 * framework hook names into the host's
 * extension mechanism.
 */
final class ThemeHooks
{
    /**
     * Fired immediately before rendering begins.
     */
    public const BEFORE_RENDER = 'platinum.before_render';

    /**
     * Fired immediately after rendering completes.
     */
    public const AFTER_RENDER = 'platinum.after_render';

    /**
     * Allows the presentation context to be
     * enriched before rendering.
     */
    public const VIEW_CONTEXT = 'platinum.view_context';

    /**
     * Allows assets to be modified before
     * being published.
     */
    public const ASSETS = 'platinum.assets';

    /**
     * Prevent instantiation.
     */
    private function __construct()
    {
    }
}