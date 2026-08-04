<?php

declare(strict_types=1);

namespace Platinum\Core\Scheduling;

use Platinum\Core\Scheduling\Contracts\JobInterface;
use Platinum\Core\Scheduling\Contracts\SchedulerInterface;

/**
 * Concrete scheduler implementation.
 */
final class Scheduler implements SchedulerInterface
{
    private TaskRegistry $registry;

    public function __construct(TaskRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function call(callable|JobInterface|string $job, array $args = []): Task
    {
        $task = new Task($job, $args);
        $this->registry->add($task);

        return $task;
    }

    public function tasks(): array
    {
        return $this->registry->all();
    }

    public function runDue(): void
    {
        $now = time();

        foreach ($this->registry->all() as $task) {
            if ($task->isDue($now)) {
                $task->execute();
            }
        }
    }
}