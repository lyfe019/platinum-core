<?php

declare(strict_types=1);

namespace Platinum\Core\Providers;

use Platinum\Core\Container\ServiceProvider;
use Platinum\Core\Scheduling\Contracts\SchedulerInterface;
use Platinum\Core\Scheduling\Scheduler;
use Platinum\Core\Scheduling\TaskRegistry;

/**
 * Registers task scheduling bindings into the service container.
 */
final class SchedulingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->container->singleton(TaskRegistry::class, function () {
            return new TaskRegistry();
        });

        $this->container->singleton(SchedulerInterface::class, function () {
            return new Scheduler($this->container->make(TaskRegistry::class));
        });

        $this->container->alias(SchedulerInterface::class, Scheduler::class);
    }
}