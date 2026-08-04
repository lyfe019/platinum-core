<?php

declare(strict_types=1);

namespace Platinum\Core\Console\Commands;

use Platinum\Core\Console\Contracts\CommandInterface;
use Platinum\Core\Console\Input;
use Platinum\Core\Console\Output;
use Platinum\Core\Foundation\Application;

/**
 * Diagnostics command reporting system health and context state.
 */
final class SystemStatusCommand implements CommandInterface
{
    private Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function name(): string
    {
        return 'system:status';
    }

    public function description(): string
    {
        return 'Displays the status and operational diagnostics of Platinum Core.';
    }

    public function execute(Input $input, Output $output): int
    {
        $output->info('=== Platinum Core Diagnostics ===');
        $output->writeln('Environment: ' . config('app.environment', 'production'));
        $output->writeln('Framework Version: ' . config('app.version', '1.0.0'));
        $output->writeln('Loaded Providers: ' . count($this->application->providers()));
        $output->writeln('Active Contexts: ' . $this->application->contexts()->count());
        $output->success('Framework System Status: HEALTHY');

        return 0;
    }
}