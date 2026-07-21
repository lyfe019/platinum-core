<?php

declare(strict_types=1);

namespace Platinum\Core\Contexts;

use Platinum\Core\Foundation\Application;

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
     * Discover available contexts.
     *
     * For now, the framework intentionally discovers nothing.
     * Automatic discovery will be implemented later.
     *
     * @return array<int, ContextInterface>
     */
    public function discover(): array
    {
        return [];
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

        foreach ($this->discover() as $context) {
            $this->register($context);
        }

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