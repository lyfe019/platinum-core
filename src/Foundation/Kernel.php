<?php

declare(strict_types=1);

namespace Platinum\Core\Foundation;

use Platinum\Core\Providers\ClockServiceProvider;

final class Kernel
{
    /**
     * Running application.
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

        $application = new Application();

        /*
        |--------------------------------------------------------------------------
        | Register Framework Providers
        |--------------------------------------------------------------------------
        */

        $application->register(
            new ClockServiceProvider($application)
        );

        /*
        |--------------------------------------------------------------------------
        | Boot Providers
        |--------------------------------------------------------------------------
        */

        $application->bootProviders();

        self::$application = $application;

        return self::$application;
    }

    /**
     * Return the running application.
     */
    public static function application(): Application
    {
        return self::$application ?? self::boot();
    }
}