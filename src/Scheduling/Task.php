<?php

declare(strict_types=1);

namespace Platinum\Core\Scheduling;

use Platinum\Core\Scheduling\Contracts\JobInterface;
use Throwable;

/**
 * Value object representing a single scheduled task and its execution criteria.
 */
final class Task
{
    private string $id;
    /** @var callable|JobInterface|string */
    private $action;
    /** @var array<int, mixed> */
    private array $args;
    private string $expression = '* * * * *';
    private string $frequency = 'hourly';
    private ?int $lastRunTimestamp = null;

    /**
     * @param callable|JobInterface|string $action
     * @param array<int, mixed> $args
     */
    public function __construct(callable|JobInterface|string $action, array $args = [])
    {
        $this->id = md5(is_string($action) ? $action : uniqid('task_', true));
        $this->action = $action;
        $this->args = $args;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function hourly(): self
    {
        $this->frequency = 'hourly';
        $this->expression = '0 * * * *';
        return $this;
    }

    public function daily(): self
    {
        $this->frequency = 'daily';
        $this->expression = '0 0 * * *';
        return $this;
    }

    public function weekly(): self
    {
        $this->frequency = 'weekly';
        $this->expression = '0 0 * * 0';
        return $this;
    }

    public function cron(string $expression): self
    {
        $this->expression = $expression;
        $this->frequency = 'custom';
        return $this;
    }

    public function frequency(): string
    {
        return $this->frequency;
    }

    public function expression(): string
    {
        return $this->expression;
    }

    /**
     * Evaluates if the task should run based on last execution timestamp.
     */
    public function isDue(int $currentTimestamp): bool
    {
        if ($this->lastRunTimestamp === null) {
            return true;
        }

        $elapsed = $currentTimestamp - $this->lastRunTimestamp;

        return match ($this->frequency) {
            'hourly' => $elapsed >= 3600,
            'daily' => $elapsed >= 86400,
            'weekly' => $elapsed >= 604800,
            default => $elapsed >= 60,
        };
    }

    /**
     * Executes the task action.
     */
    public function execute(): void
    {
        $this->lastRunTimestamp = time();

        if ($this->action instanceof JobInterface) {
            $this->action->handle();
            return;
        }

        if (is_callable($this->action)) {
            call_user_func_array($this->action, $this->args);
            return;
        }

        if (is_string($this->action) && class_exists($this->action)) {
            $instance = new $this->action();
            if ($instance instanceof JobInterface) {
                $instance->handle();
                return;
            }
            if (is_callable($instance)) {
                $instance(...$this->args);
            }
        }
    }
}