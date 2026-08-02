<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Immutable Style Value Object.
 */
final class Style
{
    private string $handle;
    private string $src;
    /** @var string[] */
    private array $dependencies;
    private ?string $version;
    private string $media;

    /**
     * @param string[] $dependencies
     */
    public function __construct(
        string $handle,
        string $src,
        array $dependencies = [],
        ?string $version = null,
        string $media = 'all'
    ) {
        $this->handle = $handle;
        $this->src = $src;
        $this->dependencies = array_values($dependencies);
        $this->version = $version;
        $this->media = $media;
    }

    public function handle(): string
    {
        return $this->handle;
    }

    public function src(): string
    {
        return $this->src;
    }

    /**
     * @return string[]
     */
    public function dependencies(): array
    {
        return $this->dependencies;
    }

    public function version(): ?string
    {
        return $this->version;
    }

    public function media(): string
    {
        return $this->media;
    }

    public function withVersion(string $version): self
    {
        return new self($this->handle, $this->src, $this->dependencies, $version, $this->media);
    }
}