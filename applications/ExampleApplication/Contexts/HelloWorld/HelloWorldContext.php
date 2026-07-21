<?php

declare(strict_types=1);

namespace Platinum\Applications\ExampleApplication\Contexts\HelloWorld;

use Platinum\Core\Contexts\AbstractContext;

/**
 * Example Hello World Context.
 */
final class HelloWorldContext extends AbstractContext
{
    /**
     * Indicates whether initialization has completed.
     */
    private bool $initialized = false;

    /**
     * Indicates whether boot has completed.
     */
    private bool $booted = false;

    /**
     * Context name.
     */
    public function name(): string
    {
        return 'HelloWorld';
    }

    /**
     * Initialize the context.
     */
    public function initialize(): void
    {
        $this->initialized = true;
    }

    /**
     * Boot the context.
     */
    public function boot(): void
    {
        $this->booted = true;
    }

    /**
     * Determine whether initialization has completed.
     */
    public function initialized(): bool
    {
        return $this->initialized;
    }

    /**
     * Determine whether boot has completed.
     */
    public function booted(): bool
    {
        return $this->booted;
    }
}