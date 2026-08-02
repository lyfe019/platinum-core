<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Strongly-typed configuration Value Object for the Presentation Subsystem.
 */
final class ViewConfig
{
    /** @var string[] */
    private array $templatePaths;
    private string $cachePath;
    private bool $cacheEnabled;
    private ?string $defaultLayout;
    private string $assetBaseUrl;
    private bool $debug;

    /**
     * @param string[] $templatePaths
     */
    public function __construct(
        array $templatePaths = [],
        string $cachePath = '',
        bool $cacheEnabled = false,
        ?string $defaultLayout = null,
        string $assetBaseUrl = '',
        bool $debug = false
    ) {
        $this->templatePaths = array_values($templatePaths);
        $this->cachePath = $cachePath;
        $this->cacheEnabled = $cacheEnabled;
        $this->defaultLayout = $defaultLayout;
        $this->assetBaseUrl = $assetBaseUrl;
        $this->debug = $debug;
    }

    /**
     * Creates a ViewConfig instance from a standard key-value array.
     *
     * @param array<string, mixed> $config
     */
    public static function fromArray(array $config): self
    {
        return new self(
            (array) ($config['paths'] ?? []),
            (string) ($config['cache_path'] ?? ''),
            (bool) ($config['cache_enabled'] ?? false),
            isset($config['default_layout']) ? (string) $config['default_layout'] : null,
            (string) ($config['asset_base_url'] ?? ''),
            (bool) ($config['debug'] ?? false)
        );
    }

    /**
     * @return string[]
     */
    public function templatePaths(): array
    {
        return $this->templatePaths;
    }

    public function cachePath(): string
    {
        return $this->cachePath;
    }

    public function isCacheEnabled(): bool
    {
        return $this->cacheEnabled;
    }

    public function defaultLayout(): ?string
    {
        return $this->defaultLayout;
    }

    public function assetBaseUrl(): string
    {
        return $this->assetBaseUrl;
    }

    public function isDebug(): bool
    {
        return $this->debug;
    }
}