<?php

declare(strict_types=1);

namespace Platinum\Core\Container;

use Platinum\Core\Foundation\Application;

abstract class ServiceProvider
{
    /**
     * Running application.
     */
    protected Application $app;

    /**
     * Create provider.
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Register services.
     */
    abstract public function register(): void;

    /**
     * Boot services.
     */
    public function boot(): void
    {
        //
    }
}