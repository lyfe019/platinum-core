<?php

declare(strict_types=1);

namespace Platinum\Core\Console\Contracts;

use Platinum\Core\Console\Input;
use Platinum\Core\Console\Output;

/**
 * Contract for console commands.
 */
interface CommandInterface
{
    /**
     * Unique command signature/name (e.g., 'system:status', 'cache:clear').
     */
    public function name(): string;

    /**
     * Brief human-readable description of the command.
     */
    public function description(): string;

    /**
     * Execute the command logic.
     *
     * @return int Exit status code (0 = SUCCESS, 1 = FAILURE).
     */
    public function execute(Input $input, Output $output): int;
}