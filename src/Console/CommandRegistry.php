<?php

declare(strict_types=1);

namespace Platinum\Core\Console;

use Platinum\Core\Console\Contracts\CommandInterface;

/**
 * Registry storing all active CLI commands.
 */
final class CommandRegistry
{
    /** @var array<string, CommandInterface> */
    private array $commands = [];

    public function add(CommandInterface $command): void
    {
        $this->commands[$command->name()] = $command;
    }

    public function get(string $name): ?CommandInterface
    {
        return $this->commands[$name] ?? null;
    }

    public function has(string $name): bool
    {
        return isset($this->commands[$name]);
    }

    /**
     * @return array<string, CommandInterface>
     */
    public function all(): array
    {
        return $this->commands;
    }
}