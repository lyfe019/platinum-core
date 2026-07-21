<?php

declare(strict_types=1);

namespace Platinum\Core\Contexts;

use Platinum\Core\Foundation\Application;
use Platinum\Applications\ExampleApplication\ExampleApplication;

/**
 * Context Loader.
 *
 * Responsible for the bounded context lifecycle.
 *
 * Lifecycle
 *
 * discover()
 *      ↓
 * register()
 *      ↓
 * initialize()
 *      ↓
 * boot()
 *
 * The loader never owns contexts.
 * All contexts are stored in the ContextRegistry.
 */
final class ContextLoader
{
    /**
     * Running application.
     */
    private Application $application;

    /**
     * Context registry.
     */
    private ContextRegistry $registry;

    /**
     * Create a new context loader.
     */
    public function __construct(Application $application)
    {
        $this->application = $application;

        $this->registry = $application->contexts();
    }

    /**
     * Discover application contexts.
     */
    public function discover(): void
    {
        $application = new ExampleApplication();

        $application->registerContexts($this);
    }

    /**
     * Register a bounded context.
     */
    public function register(ContextInterface $context): void
    {
        $this->registry->register($context);
    }

    /**
     * Initialize all registered contexts.
     */
    public function initialize(): void
    {
        foreach ($this->registry->all() as $context) {
            $context->initialize();
        }
    }

    /**
     * Boot all registered contexts.
     */
    public function boot(): void
    {
        foreach ($this->registry->all() as $context) {
            $context->boot();
        }
    }

    /**
     * Execute the complete context lifecycle.
     */
    public function load(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Discover Contexts
        |--------------------------------------------------------------------------
        */

        $this->discover();

        /*
        |--------------------------------------------------------------------------
        | Initialize Contexts
        |--------------------------------------------------------------------------
        */

        $this->initialize();

        /*
        |--------------------------------------------------------------------------
        | Boot Contexts
        |--------------------------------------------------------------------------
        */

        $this->boot();
    }

    /**
     * Return the application's context registry.
     */
    public function registry(): ContextRegistry
    {
        return $this->registry;
    }

    /**
     * Return the running application.
     */
    public function application(): Application
    {
        return $this->application;
    }
}