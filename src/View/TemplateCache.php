<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use RuntimeException;

/**
 * Handles compiled template storage, freshness checks, and cache invalidation.
 */
final class TemplateCache
{
    private string $cachePath;
    private bool $enabled;

    public function __construct(string $cachePath, bool $enabled = true)
    {
        $this->cachePath = rtrim($cachePath, '/\\');
        $this->enabled = $enabled;
    }

    /**
     * Returns whether template caching is active.
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Computes a deterministic cache key path for a template file.
     */
    public function getCompiledPath(string $templatePath): string
    {
        $hash = sha1($templatePath);
        return $this->cachePath . '/' . $hash . '.php';
    }

    /**
     * Checks if a cached compilation exists and is up to date relative to the source template.
     */
    public function isExpired(string $templatePath): bool
    {
        if (!$this->enabled) {
            return true;
        }

        $compiledPath = $this->getCompiledPath($templatePath);

        if (!file_exists($compiledPath)) {
            return true;
        }

        return filemtime($compiledPath) < filemtime($templatePath);
    }

    /**
     * Writes compiled template content to disk atomically.
     */
    public function put(string $templatePath, string $compiledContent): string
    {
        if (!is_dir($this->cachePath)) {
            if (!mkdir($this->cachePath, 0755, true) && !is_dir($this->cachePath)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created.', $this->cachePath));
            }
        }

        $compiledPath = $this->getCompiledPath($templatePath);
        $tempPath = $compiledPath . '.' . uniqid('tmp_', true);

        if (file_put_contents($tempPath, $compiledContent) === false) {
            throw new RuntimeException(sprintf('Failed to write template cache file: "%s".', $tempPath));
        }

        rename($tempPath, $compiledPath);

        return $compiledPath;
    }

    /**
     * Clears all cached compiled template files.
     */
    public function clear(): bool
    {
        if (!is_dir($this->cachePath)) {
            return true;
        }

        $files = glob($this->cachePath . '/*.php');
        if ($files === false) {
            return false;
        }

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        return true;
    }
}