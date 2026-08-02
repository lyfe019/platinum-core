<?php

declare(strict_types=1);

namespace Platinum\Core\View\Bridges;

/**
 * Interface for host environment integration adapters.
 */
interface HostBridgeInterface
{
    /**
     * Register asset with the host system's queue.
     */
    public function enqueueAsset(string $handle, string $url, array $deps = [], string $version = ''): void;

    /**
     * Dispatch an action or hook event to the host platform.
     *
     * @param array<int, mixed> $args
     */
    public function dispatchHook(string $hookName, array $args = []): void;

    /**
     * Retrieve a global or context option from the host system.
     */
    public function getHostOption(string $key, mixed $default = null): mixed;
}