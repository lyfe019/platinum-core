<?php

declare(strict_types=1);

namespace Platinum\Core\Foundation;

/**
 * Determines the current runtime environment.
 */
final class Environment
{
    public const PRODUCTION = 'production';

    public const DEVELOPMENT = 'development';

    public const TESTING = 'testing';

    /**
     * Detect the current environment.
     */
    public static function detect(): string
    {
        if (defined('PLATINUM_ENV')) {
            return PLATINUM_ENV;
        }

        if (defined('WP_ENVIRONMENT_TYPE')) {
            return WP_ENVIRONMENT_TYPE;
        }

        return self::PRODUCTION;
    }

    /**
     * Determine whether the environment is production.
     */
    public static function isProduction(): bool
    {
        return self::detect() === self::PRODUCTION;
    }

    /**
     * Determine whether the environment is development.
     */
    public static function isDevelopment(): bool
    {
        return self::detect() === self::DEVELOPMENT;
    }

    /**
     * Determine whether the environment is testing.
     */
    public static function isTesting(): bool
    {
        return self::detect() === self::TESTING;
    }
}