<?php

declare(strict_types=1);

use Platinum\Core\Configuration\ConfigRepository;

if (! function_exists('config')) {

    /**
     * Retrieve configuration values.
     */
    function config(string $key, mixed $default = null): mixed
    {
        return ConfigRepository::get($key, $default);
    }
}