<?php

declare(strict_types=1);

namespace Platinum\Core\Providers;

use Platinum\Core\Container\ServiceProvider;
use Platinum\Core\Http\ApiKernel;
use Platinum\Core\Http\Controllers\StatusController;
use Platinum\Core\Http\Router;
use Platinum\Core\Integration\WordPress\WordPressRequestAdapter;
use Platinum\Core\Integration\WordPress\WordPressResponseAdapter;

/**
 * HTTP Service Provider.
 *
 * Registers the framework HTTP subsystem.
 */
final class HttpServiceProvider extends ServiceProvider
{
    /**
     * Register HTTP services.
     */
    public function register(): void
    {
        $container = $this->app->container();

        /*
        |--------------------------------------------------------------------------
        | Router
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            Router::class,
            fn () => new Router()
        );

        /*
        |--------------------------------------------------------------------------
        | API Kernel
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            ApiKernel::class,
            fn () => new ApiKernel(
                $container->make(Router::class)
            )
        );

        /*
        |--------------------------------------------------------------------------
        | WordPress Request Adapter
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            WordPressRequestAdapter::class,
            fn () => new WordPressRequestAdapter()
        );

        /*
        |--------------------------------------------------------------------------
        | WordPress Response Adapter
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            WordPressResponseAdapter::class,
            fn () => new WordPressResponseAdapter()
        );
    }

    /**
     * Boot HTTP services.
     */
    public function boot(): void
    {
        /** @var Router $router */
        $router = $this->app
            ->container()
            ->make(Router::class);

        /*
        |--------------------------------------------------------------------------
        | Framework Routes
        |--------------------------------------------------------------------------
        */

        $router->get(
            '/status',
            StatusController::class
        );
    }
}