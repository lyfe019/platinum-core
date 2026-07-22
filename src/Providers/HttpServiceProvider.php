<?php

declare(strict_types=1);

namespace Platinum\Core\Providers;

use Platinum\Core\Container\ServiceProvider;
use Platinum\Core\Contracts\Logger;
use Platinum\Core\Contracts\RateLimiter;
use Platinum\Core\Http\ApiKernel;
use Platinum\Core\Http\Controllers\StatusController;
use Platinum\Core\Http\Middleware\AuthenticationMiddleware;
use Platinum\Core\Http\Middleware\ExceptionMiddleware;
use Platinum\Core\Http\Middleware\FrameworkVerificationMiddleware;
use Platinum\Core\Http\Middleware\LoggingMiddleware;
use Platinum\Core\Http\Middleware\MiddlewarePipeline;
use Platinum\Core\Http\Middleware\MiddlewareStack;
use Platinum\Core\Http\Middleware\RateLimitingMiddleware;
use Platinum\Core\Http\Router;
use Platinum\Core\Integration\WordPress\WordPressRequestAdapter;
use Platinum\Core\Integration\WordPress\WordPressResponseAdapter;
use Platinum\Core\Logging\DefaultLogger;
use Platinum\Core\RateLimiting\InMemoryRateLimiter;

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
        | Middleware Stack
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            MiddlewareStack::class,
            fn () => new MiddlewareStack()
        );

        /*
        |--------------------------------------------------------------------------
        | Middleware Pipeline
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            MiddlewarePipeline::class,
            fn () => new MiddlewarePipeline()
        );

        /*
        |--------------------------------------------------------------------------
        | Logger
        |--------------------------------------------------------------------------
        |
        | Register the framework logger.
        | All framework components depend on the Logger contract rather
        | than a concrete logging implementation.
        |
        */

        $container->singleton(
            Logger::class,
            fn () => new DefaultLogger()
        );

        /*
        |--------------------------------------------------------------------------
        | Rate Limiter
        |--------------------------------------------------------------------------
        |
        | Register the framework rate limiter.
        | Middleware depends on the RateLimiter contract rather than
        | a concrete implementation.
        |
        */

        $container->singleton(
            RateLimiter::class,
            fn () => new InMemoryRateLimiter()
        );

        /*
        |--------------------------------------------------------------------------
        | Middleware
        |--------------------------------------------------------------------------
        |
        | Register framework middleware. These are resolved from the
        | container so they can receive constructor-injected dependencies.
        |
        */

        $container->singleton(
            ExceptionMiddleware::class,
            fn () => new ExceptionMiddleware()
        );

        $container->singleton(
            LoggingMiddleware::class,
            fn () => new LoggingMiddleware(
                $container->make(Logger::class)
            )
        );

        $container->singleton(
            RateLimitingMiddleware::class,
            fn () => new RateLimitingMiddleware(
                $container->make(RateLimiter::class)
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Authentication Middleware
        |--------------------------------------------------------------------------
        |
        | Register the framework authentication middleware.
        | Authentication logic will be introduced in the Identity
        | subsystem. For now, the middleware occupies its place
        | in the global pipeline.
        |
        */

        $container->singleton(
            AuthenticationMiddleware::class,
            fn () => new AuthenticationMiddleware()
        );

        $container->singleton(
            FrameworkVerificationMiddleware::class,
            fn () => new FrameworkVerificationMiddleware()
        );

        /*
        |--------------------------------------------------------------------------
        | API Kernel
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            ApiKernel::class,
            fn () => new ApiKernel(
                $container->make(Router::class),
                $container->make(MiddlewareStack::class),
                $container->make(MiddlewarePipeline::class),
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
        $container = $this->app->container();

        /** @var Router $router */
        $router = $container->make(
            Router::class
        );

        /** @var MiddlewareStack $stack */
        $stack = $container->make(
            MiddlewareStack::class
        );

        /*
        |--------------------------------------------------------------------------
        | Global Middleware
        |--------------------------------------------------------------------------
        |
        | Middleware execute in the order they are registered.
        | ExceptionMiddleware wraps the entire pipeline.
        | LoggingMiddleware records every request.
        | RateLimitingMiddleware throttles excessive requests.
        | AuthenticationMiddleware authenticates the current actor.
        | FrameworkVerificationMiddleware verifies the middleware pipeline.
        |
        */

        $stack->push(
            $container->make(ExceptionMiddleware::class)
        );

        $stack->push(
            $container->make(LoggingMiddleware::class)
        );

        $stack->push(
            $container->make(RateLimitingMiddleware::class)
        );

        $stack->push(
            $container->make(AuthenticationMiddleware::class)
        );

        $stack->push(
            $container->make(FrameworkVerificationMiddleware::class)
        );

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