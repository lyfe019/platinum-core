<?php

declare(strict_types=1);

namespace Platinum\Core\Foundation;

/**
 * Boots the Platinum Core framework.
 */
final class Kernel
{
    /**
     * The running application instance.
     */
    private static ?Application $application = null;

    /**
     * Boot the framework.
     */
    public static function boot(): Application
    {
        if (self::$application instanceof Application) {
            return self::$application;
        }

        self::$application = new Application(
            Environment::detect()
        );

        return self::$application;
    }
}