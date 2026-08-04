<?php

declare(strict_types=1);

namespace Platinum\Core\Console;

/**
 * Value Object encapsulating command input arguments and options.
 */
final class Input
{
    /** @var array<string, mixed> */
    private array $arguments;
    /** @var array<string, mixed> */
    private array $options;

    /**
     * @param array<string, mixed> $arguments
     * @param array<string, mixed> $options
     */
    public function __construct(array $arguments = [], array $options = [])
    {
        $this->arguments = $arguments;
        $this->options = $options;
    }

    public function argument(string $key, mixed $default = null): mixed
    {
        return $this->arguments[$key] ?? $default;
    }

    public function option(string $key, mixed $default = null): mixed
    {
        return $this->options[$key] ?? $default;
    }

    public function hasOption(string $key): bool
    {
        return isset($this->options[$key]);
    }
}