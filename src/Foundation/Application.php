<?php

declare(strict_types=1);

namespace Platinum\Core\Foundation;

/**
 * Represents the running Platinum application.
 */
final class Application
{
    /**
     * The current application environment.
     */
    private string $environment;

    /**
     * Indicates whether the application has booted.
     */
    private bool $booted = false;

    /**
     * Create a new application instance.
     */
    public function __construct(string $environment)
    {
        $this->environment = $environment;

        $this->booted = true;
    }

    /**
     * Get the current environment.
     */
    public function environment(): string
    {
        return $this->environment;
    }

    /**
     * Determine whether the application has booted.
     */
    public function booted(): bool
    {
        return $this->booted;
    }
}