<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Manages request-level presentation state and global scope variables.
 */
final class PresentationContext
{
    /** @var array<string, mixed> */
    private array $globals = [];
    private ?string $defaultLayout = null;
    private bool $debugMode;

    public function __construct(array $globals = [], ?string $defaultLayout = null, bool $debugMode = false)
    {
        $this->globals = $globals;
        $this->defaultLayout = $defaultLayout;
        $this->debugMode = $debugMode;
    }

    /**
     * Set a global variable accessible across all views.
     */
    public function setGlobal(string $key, mixed $value): void
    {
        $this->globals[$key] = $value;
    }

    /**
     * Retrieve global variables array.
     *
     * @return array<string, mixed>
     */
    public function globals(): array
    {
        return $this->globals;
    }

    public function setDefaultLayout(?string $layout): void
    {
        $this->defaultLayout = $layout;
    }

    public function defaultLayout(): ?string
    {
        return $this->defaultLayout;
    }

    public function isDebugMode(): bool
    {
        return $this->debugMode;
    }
}