<?php

declare(strict_types=1);

namespace Platinum\Core\View\Bridges;

/**
 * Standalone/PSR bridge for framework-agnostic environments.
 */
final class StandaloneBridge implements HostBridgeInterface
{
    /** @var array<string, array<string, mixed>> */
    private array $enqueuedAssets = [];
    /** @var array<string, mixed> */
    private array $options = [];

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function enqueueAsset(string $handle, string $url, array $deps = [], string $version = ''): void
    {
        $this->enqueuedAssets[$handle] = [
            'url' => $url,
            'deps' => $deps,
            'version' => $version,
        ];
    }

    public function dispatchHook(string $hookName, array $args = []): void
    {
        // Standalone hook handler logic or event bus forwarding can be attached here
    }

    public function getHostOption(string $key, mixed $default = null): mixed
    {
        return $this->options[$key] ?? $default;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function enqueuedAssets(): array
    {
        return $this->enqueuedAssets;
    }
}