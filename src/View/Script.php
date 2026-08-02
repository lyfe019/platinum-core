<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Immutable Script Value Object.
 */
final class Script
{
    private string $handle;
    private string $src;
    /** @var string[] */
    private array $dependencies;
    private ?string $version;
    private bool $inFooter;
    private bool $defer;
    private bool $async;
    private bool $isModule;

    /**
     * @param string[] $dependencies
     */
    public function __construct(
        string $handle,
        string $src,
        array $dependencies = [],
        ?string $version = null,
        bool $inFooter = true,
        bool $defer = false,
        bool $async = false,
        bool $isModule = false
    ) {
        $this->handle = $handle;
        $this->src = $src;
        $this->dependencies = array_values($dependencies);
        $this->version = $version;
        $this->inFooter = $inFooter;
        $this->defer = $defer;
        $this->async = $async;
        $this->isModule = $isModule;
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

    public function inFooter(): bool
    {
        return $this->inFooter;
    }

    public function isDefer(): bool
    {
        return $this->defer;
    }

    public function isAsync(): bool
    {
        return $this->async;
    }

    public function isModule(): bool
    {
        return $this->isModule;
    }
}