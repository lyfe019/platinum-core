<?php

declare(strict_types=1);

namespace Platinum\Core\Providers;

use Platinum\Core\Container\ServiceProvider;
use Platinum\Core\View\Contracts\RendererInterface;
use Platinum\Core\View\Renderer;

/**
 * View Service Provider.
 *
 * Registers the framework View subsystem.
 */
final class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register view services.
     */
    public function register(): void
    {
        $container = $this->app->container();

        /*
        |--------------------------------------------------------------------------
        | Renderer
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            RendererInterface::class,
            fn () => new Renderer()
        );
    }

    /**
     * Boot view services.
     */
    public function boot(): void
    {
        //
    }
}