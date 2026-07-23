<?php

declare(strict_types=1);

namespace Platinum\Core\Providers;

use Platinum\Core\Container\ServiceProvider;
use Platinum\Core\Integration\WordPress\WpDatabaseAdapter;
use Platinum\Core\Persistence\Contracts\DatabaseAdapter;

/**
 * Persistence Service Provider.
 *
 * Registers the framework persistence subsystem.
 */
final class PersistenceServiceProvider extends ServiceProvider
{
    /**
     * Register persistence services.
     */
    public function register(): void
    {
        $container = $this->app->container();

        /*
        |--------------------------------------------------------------------------
        | Database Adapter
        |--------------------------------------------------------------------------
        |
        | Register the framework database adapter.
        | Framework components depend on the DatabaseAdapter
        | contract rather than a host-specific implementation.
        |
        */

        $container->singleton(
            DatabaseAdapter::class,
            fn () => new WpDatabaseAdapter()
        );
    }

    /**
     * Boot persistence services.
     */
    public function boot(): void
    {
        //
    }
}