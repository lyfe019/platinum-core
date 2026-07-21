<?php

declare(strict_types=1);

namespace Platinum\Core\Support;

/**
 * Simple clock service.
 */
final class Clock
{
    /**
     * Return the current date and time.
     */
    public function now(): string
    {
        return date('Y-m-d H:i:s');
    }
}