<?php

declare(strict_types=1);

namespace Platinum\Core\Foundation;

use Platinum\Core\Events\EventBus;
use Platinum\Core\Events\Events\FrameworkStarted;
use Platinum\Core\Providers\FrameworkServiceProvider;

/**
 * Framework Kernel.
 *
 * Responsible for bootstrapping the Platinum Core framework.
 */
final class Kernel
{
    /**
     * Running application.
     */
    private static ?Application $application = null;

    /**
     * Indicates whether the framework started event
     * has been published.
     */
    private static bool $frameworkStarted = false;

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
            new FrameworkServiceProvider($application)
        );

        /*
        |--------------------------------------------------------------------------
        | Boot Providers
        |--------------------------------------------------------------------------
        */

        $application->bootProviders();

        /*
        |--------------------------------------------------------------------------
        | Load Contexts
        |--------------------------------------------------------------------------
        */

        $application
            ->contextLoader()
            ->load();

        /*
        |--------------------------------------------------------------------------
        | Publish FrameworkStarted
        |--------------------------------------------------------------------------
        */

        $application
            ->container()
            ->make(EventBus::class)
            ->publish(
                new FrameworkStarted()
            );

        self::$frameworkStarted = true;

        /*
        |--------------------------------------------------------------------------
        | Store Running Application
        |--------------------------------------------------------------------------
        */

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

    /**
     * Determine whether the framework started
     * event has been published.
     */
    public static function frameworkStarted(): bool
    {
        return self::$frameworkStarted;
    }
}