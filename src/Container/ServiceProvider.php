<?php

declare(strict_types=1);

namespace Platinum\Core\Container;

use Platinum\Core\Foundation\Application;

/**
 * Base Service Provider.
 *
 * All framework and application service providers extend this class.
 */
abstract class ServiceProvider
{
    /**
     * The running application.
     */
    protected Application $app;

    /**
     * Create a new service provider.
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Register services with the application.
     */
    abstract public function register(): void;

    /**
     * Boot services after all providers have been registered.
     */
    public function boot(): void
    {
        //
    }
}