<?php

declare(strict_types=1);

namespace Platinum\Core\Console\Contracts;

use Platinum\Core\Console\Input;
use Platinum\Core\Console\Output;

/**
 * Interface for the Console Kernel.
 */
interface ConsoleKernelInterface
{
    /**
     * Register a console command instance or class.
     */
    public function register(CommandInterface|string $command): void;

    /**
     * Dispatch and execute a command by name.
     */
    public function handle(string $commandName, Input $input, Output $output): int;

    /**
     * Retrieve all registered commands.
     *
     * @return CommandInterface[]
     */
    public function commands(): array;
}