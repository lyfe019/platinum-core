<?php

declare(strict_types=1);

namespace Platinum\Core\Scheduling;

/**
 * In-memory storage and manager for scheduled tasks.
 */
final class TaskRegistry
{
    /** @var array<string, Task> */
    private array $tasks = [];

    public function add(Task $task): void
    {
        $this->tasks[$task->id()] = $task;
    }

    /**
     * @return Task[]
     */
    public function all(): array
    {
        return array_values($this->tasks);
    }

    public function clear(): void
    {
        $this->tasks = [];
    }
}