<?php

declare(strict_types=1);

namespace Platinum\Core\Scheduling\Contracts;

use Platinum\Core\Scheduling\Task;

/**
 * Interface for the core task scheduler.
 */
interface SchedulerInterface
{
    /**
     * Schedule a job, callback, or class string.
     *
     * @param array<int, mixed> $args
     */
    public function call(callable|JobInterface|string $job, array $args = []): Task;

    /**
     * Retrieve all registered tasks.
     *
     * @return Task[]
     */
    public function tasks(): array;

    /**
     * Run all tasks that are currently due.
     */
    public function runDue(): void;
}