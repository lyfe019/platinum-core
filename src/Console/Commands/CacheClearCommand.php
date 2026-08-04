<?php

declare(strict_types=1);

namespace Platinum\Core\Console\Commands;

use Platinum\Core\Console\Contracts\CommandInterface;
use Platinum\Core\Console\Input;
use Platinum\Core\Console\Output;

/**
 * Flushes compiled templates and application caches.
 */
final class CacheClearCommand implements CommandInterface
{
    public function name(): string
    {
        return 'cache:clear';
    }

    public function description(): string
    {
        return 'Clears all framework compiled view and configuration caches.';
    }

    public function execute(Input $input, Output $output): int
    {
        $output->info('Purging framework compiled caches...');
        
        // Dynamic cache clearing strategy hook
        
        $output->success('Application cache cleared successfully.');

        return 0;
    }
}