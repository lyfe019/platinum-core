<?php

declare(strict_types=1);

namespace Platinum\Core\Contexts;

/**
 * Defines the lifecycle contract for every bounded context.
 */
interface ContextInterface
{
    /**
     * Return the unique context name.
     */
    public function name(): string;

    /**
     * Register services with the framework.
     */
    public function register(): void;

    /**
     * Initialize the context.
     *
     * Called after registration and before boot.
     */
    public function initialize(): void;

    /**
     * Boot the context.
     *
     * Called after all contexts have been initialized.
     */
    public function boot(): void;
}