<?php

declare(strict_types=1);

namespace Platinum\Core\Contexts;

use Platinum\Core\Foundation\Application;

/**
 * Base implementation for all bounded contexts.
 */
abstract class AbstractContext implements ContextInterface
{
    /**
     * Running application.
     */
    protected Application $app;

    /**
     * Create a new context.
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Register context services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Initialize the context.
     */
    public function initialize(): void
    {
        //
    }

    /**
     * Boot the context.
     */
    public function boot(): void
    {
        //
    }
}