<?php

declare(strict_types=1);

namespace Platinum\Core\Providers;

use Platinum\Core\Console\CommandRegistry;
use Platinum\Core\Console\Commands\CacheClearCommand;
use Platinum\Core\Console\Commands\SystemStatusCommand;
use Platinum\Core\Console\ConsoleKernel;
use Platinum\Core\Console\Contracts\ConsoleKernelInterface;
use Platinum\Core\Container\ServiceProvider;
use Platinum\Core\Foundation\Application;

/**
 * Registers Console bindings and default framework commands.
 */
final class ConsoleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->container->singleton(CommandRegistry::class, function () {
            return new CommandRegistry();
        });

        $this->container->singleton(ConsoleKernelInterface::class, function () {
            $kernel = new ConsoleKernel(
                $this->container->make(CommandRegistry::class),
                $this->container
            );

            // Register default built-in commands
            $kernel->register(new SystemStatusCommand($this->container->make(Application::class)));
            $kernel->register(new CacheClearCommand());

            return $kernel;
        });

        $this->container->alias(ConsoleKernelInterface::class, ConsoleKernel::class);
    }
}