<?php

declare(strict_types=1);

namespace Platinum\Core\View;

final class AssetResolver
{
    private string $baseUrl;
    /** @var array<string, string> */
    private array $manifest;

    /**
     * @param array<string, string> $manifest Mapping of logical paths to versioned/hashed file paths.
     */
    public function __construct(string $baseUrl = '', array $manifest = [])
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->manifest = $manifest;
    }

    /**
     * Resolves an asset path to its canonical URL.
     */
    public function resolve(string $path): string
    {
        $normalizedPath = ltrim($path, '/');

        if (isset($this->manifest[$normalizedPath])) {
            $normalizedPath = ltrim($this->manifest[$normalizedPath], '/');
        }

        if (filter_var($normalizedPath, FILTER_VALIDATE_URL) !== false) {
            return $normalizedPath;
        }

        if ($this->baseUrl === '') {
            return '/' . $normalizedPath;
        }

        return $this->baseUrl . '/' . $normalizedPath;
    }
}