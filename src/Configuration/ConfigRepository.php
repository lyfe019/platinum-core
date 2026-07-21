<?php

declare(strict_types=1);

namespace Platinum\Core\Configuration;

final class ConfigRepository
{
    /**
     * Loaded configuration.
     *
     * @var array<string, mixed>
     */
    private static array $items = [];

    /**
     * Indicates whether configuration has been loaded.
     */
    private static bool $loaded = false;

    /**
     * Load all configuration files.
     */
    public static function load(): void
    {
        if (self::$loaded) {
            return;
        }

        $configPath = PLATINUM_CONFIG_PATH;

        foreach (glob($configPath . '/*.php') as $file) {

            $key = basename($file, '.php');

            self::$items[$key] = require $file;
        }

        self::$loaded = true;
    }

    /**
     * Retrieve a configuration value.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        self::load();

        $segments = explode('.', $key);

        $value = self::$items;

        foreach ($segments as $segment) {

            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }

            $value = $value[$segment];
        }

        return $value;
    }

    /**
     * Determine if a configuration key exists.
     */
    public static function has(string $key): bool
    {
        return self::get($key, '__missing__') !== '__missing__';
    }

    /**
     * Return all configuration.
     */
    public static function all(): array
    {
        self::load();

        return self::$items;
    }
}