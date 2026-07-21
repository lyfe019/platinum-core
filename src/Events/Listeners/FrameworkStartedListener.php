<?php

declare(strict_types=1);

namespace Platinum\Core\Events\Listeners;

use Platinum\Core\Events\Events\FrameworkStarted;

/**
 * Verifies that the FrameworkStarted event
 * was successfully dispatched.
 */
final class FrameworkStartedListener
{
    /**
     * Indicates whether the listener executed.
     */
    private static bool $executed = false;

    /**
     * Handle the event.
     */
    public function onFrameworkStarted(
        FrameworkStarted $event
    ): void {
        self::$executed = true;
    }

    /**
     * Determine whether the listener executed.
     */
    public static function executed(): bool
    {
        return self::$executed;
    }
}