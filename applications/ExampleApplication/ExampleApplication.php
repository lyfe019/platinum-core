<?php

declare(strict_types=1);

namespace Platinum\Applications\ExampleApplication;

use Platinum\Core\Contexts\ContextLoader;
use Platinum\Applications\ExampleApplication\Contexts\HelloWorld\HelloWorldContext;

/**
 * Example Application.
 *
 * Registers the example bounded contexts used to verify
 * the framework runtime.
 */
final class ExampleApplication
{
    /**
     * Register application contexts.
     */
    public function registerContexts(ContextLoader $loader): void
    {
        $loader->register(
            new HelloWorldContext()
        );
    }
}