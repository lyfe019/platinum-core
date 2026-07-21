<?php

declare(strict_types=1);

namespace Platinum\Core\Providers;

use Platinum\Core\Container\ServiceProvider;
use Platinum\Core\Configuration\ConfigRepository;

/**
 * Configuration Service Provider.
 *
 * Loads the framework configuration.
 */
final class ConfigurationServiceProvider extends ServiceProvider
{
    /**
     * Register configuration services.
     */
    public function register(): void
    {
        ConfigRepository::load();
    }

    /**
     * Boot configuration services.
     */
    public function boot(): void
    {
        //
    }
}