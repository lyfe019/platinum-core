<?php

declare(strict_types=1);

namespace Platinum\Core\Contexts;

/**
 * Base implementation for all bounded contexts.
 */
abstract class AbstractContext implements ContextInterface
{
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