<?php

declare(strict_types=1);

namespace Platinum\Core\Console;

use Platinum\Core\Console\Contracts\CommandInterface;
use Platinum\Core\Console\Contracts\ConsoleKernelInterface;
use Platinum\Core\Container\Container;
use RuntimeException;

/**
 * Framework Console Kernel implementation.
 */
final class ConsoleKernel implements ConsoleKernelInterface
{
    private CommandRegistry $registry;
    private Container $container;

    public function __construct(CommandRegistry $registry, Container $container)
    {
        $this->registry = $registry;
        $this->container = $container;
    }

    public function register(CommandInterface|string $command): void
    {
        if (is_string($command)) {
            /** @var CommandInterface $command */
            $command = $this->container->make($command);
        }

        $this->registry->add($command);
    }

    public function handle(string $commandName, Input $input, Output $output): int
    {
        $command = $this->registry->get($commandName);

        if ($command === null) {
            $output->error(sprintf('Command "%s" is not registered.', $commandName));
            return 1;
        }

        try {
            return $command->execute($input, $output);
        } catch (\Throwable $e) {
            $output->error(sprintf('Execution failed: %s', $e->getMessage()));
            return 1;
        }
    }

    public function commands(): array
    {
        return array_values($this->registry->all());
    }
}