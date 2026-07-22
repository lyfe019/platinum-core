<?php

declare(strict_types=1);

namespace Platinum\Core\Providers;

use Platinum\Core\Container\ServiceProvider;

/**
 * Registers all built-in framework providers.
 */
final class FrameworkServiceProvider extends ServiceProvider
{
    /**
     * Register framework providers.
     */
    public function register(): void
    {
        $this->app->register(
            new ConfigurationServiceProvider($this->app)
        );

        $this->app->register(
            new ClockServiceProvider($this->app)
        );

        $this->app->register(
            new EventServiceProvider($this->app)
        );

        $this->app->register(
            new RoutingServiceProvider($this->app)
        );

        $this->app->register(
            new IdentityServiceProvider($this->app)
        );

        $this->app->register(
            new ViewServiceProvider($this->app)
        );

        $this->app->register(
            new HttpServiceProvider($this->app)
        );
    }
}