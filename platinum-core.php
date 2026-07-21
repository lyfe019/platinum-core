<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Platinum Core Framework
|--------------------------------------------------------------------------
|
| Framework bootstrap entry point.
|
*/

defined('ABSPATH') || exit;

/*
|--------------------------------------------------------------------------
| Framework Constants
|--------------------------------------------------------------------------
*/

define('PLATINUM_VERSION', '1.0.0');

define('PLATINUM_PATH', __DIR__);

define('PLATINUM_SRC_PATH', PLATINUM_PATH . '/src');

define('PLATINUM_CONFIG_PATH', PLATINUM_PATH . '/config');

define('PLATINUM_STORAGE_PATH', PLATINUM_PATH . '/storage');

/*
|--------------------------------------------------------------------------
| Composer Autoloader
|--------------------------------------------------------------------------
*/

$autoload = PLATINUM_PATH . '/vendor/autoload.php';

if (! file_exists($autoload)) {
    throw new RuntimeException(
        'Composer autoloader not found. Run "composer install".'
    );
}

require_once $autoload;

/*
|--------------------------------------------------------------------------
| Framework Helpers
|--------------------------------------------------------------------------
*/

require_once PLATINUM_SRC_PATH . '/Support/helpers.php';

/*
|--------------------------------------------------------------------------
| Boot Framework
|--------------------------------------------------------------------------
*/

use Platinum\Core\Foundation\Kernel;

Kernel::boot();