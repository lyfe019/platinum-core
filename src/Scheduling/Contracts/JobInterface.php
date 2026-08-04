<?php

declare(strict_types=1);

namespace Platinum\Core\Scheduling\Contracts;

/**
 * Interface for background jobs executed by the scheduler.
 */
interface JobInterface
{
    /**
     * Execute the job payload.
     */
    public function handle(): void;
}