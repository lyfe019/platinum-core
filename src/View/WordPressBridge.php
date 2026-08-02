<?php

declare(strict_types=1);

namespace Platinum\Core\View\Bridges;

/**
 * WordPress platform adapter bridging view operations to core WP hooks and assets.
 */
final class WordPressBridge implements HostBridgeInterface
{
    public function enqueueAsset(string $handle, string $url, array $deps = [], string $version = ''): void
    {
        $extension = pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION);

        if ($extension === 'css') {
            if (function_exists('wp_enqueue_style')) {
                wp_enqueue_style($handle, $url, $deps, $version ?: false);
            }
            return;
        }

        if (function_exists('wp_enqueue_script')) {
            wp_enqueue_script($handle, $url, $deps, $version ?: false, true);
        }
    }

    public function dispatchHook(string $hookName, array $args = []): void
    {
        if (function_exists('do_action')) {
            do_action($hookName, ...$args);
        }
    }

    public function getHostOption(string $key, mixed $default = null): mixed
    {
        if (function_exists('get_option')) {
            return get_option($key, $default);
        }

        return $default;
    }
}