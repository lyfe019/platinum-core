<?php

declare(strict_types=1);

namespace Platinum\Core\Providers;

use Platinum\Core\Container\ServiceProvider;

/**
 * Framework Service Provider.
 *
 * Registers all built-in framework service providers.
 *
 * This provider acts as the composition root for the
 * Platinum Core framework by registering each framework
 * subsystem in the correct order.
 */
final class FrameworkServiceProvider extends ServiceProvider
{
    /**
     * Register framework providers.
     */
    public function register(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Configuration
        |--------------------------------------------------------------------------
        */

        $this->app->register(
            new ConfigurationServiceProvider($this->app)
        );

        /*
        |--------------------------------------------------------------------------
        | Support Services
        |--------------------------------------------------------------------------
        */

        $this->app->register(
            new ClockServiceProvider($this->app)
        );

        /*
        |--------------------------------------------------------------------------
        | Event System
        |--------------------------------------------------------------------------
        */

        $this->app->register(
            new EventServiceProvider($this->app)
        );

        /*
        |--------------------------------------------------------------------------
        | Routing
        |--------------------------------------------------------------------------
        */

        $this->app->register(
            new RoutingServiceProvider($this->app)
        );

        /*
        |--------------------------------------------------------------------------
        | Identity
        |--------------------------------------------------------------------------
        */

        $this->app->register(
            new IdentityServiceProvider($this->app)
        );

        /*
        |--------------------------------------------------------------------------
        | Persistence
        |--------------------------------------------------------------------------
        */

        $this->app->register(
            new PersistenceServiceProvider($this->app)
        );

        /*
        |--------------------------------------------------------------------------
        | View Engine
        |--------------------------------------------------------------------------
        */

        $this->app->register(
            new ViewServiceProvider($this->app)
        );

        /*
        |--------------------------------------------------------------------------
        | HTTP
        |--------------------------------------------------------------------------
        */

        $this->app->register(
            new HttpServiceProvider($this->app)
        );
    }
}