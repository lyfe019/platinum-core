<?php

declare(strict_types=1);

namespace Platinum\Core\Support;

/**
 * Demonstrates constructor dependency injection.
 */
final class ClockFormatter
{
    /**
     * Create a formatter.
     */
    public function __construct(
        private Clock $clock
    ) {
    }

    /**
     * Return formatted time.
     */
    public function formatted(): string
    {
        return 'Current Time: ' . $this->clock->now();
    }
}