<?php

declare(strict_types=1);

namespace Platinum\Core\Contexts;

use InvalidArgumentException;

/**
 * Stores and manages all registered bounded contexts.
 */
final class ContextRegistry
{
    /**
     * Registered contexts.
     *
     * @var array<string, ContextInterface>
     */
    private array $contexts = [];

    /**
     * Register a context.
     */
    public function register(ContextInterface $context): void
    {
        $name = $context->name();

        if ($this->has($name)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Context [%s] has already been registered.',
                    $name
                )
            );
        }

        $this->contexts[$name] = $context;
    }

    /**
     * Determine whether a context exists.
     */
    public function has(string $name): bool
    {
        return isset($this->contexts[$name]);
    }

    /**
     * Retrieve a registered context.
     */
    public function get(string $name): ContextInterface
    {
        if (! $this->has($name)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Context [%s] has not been registered.',
                    $name
                )
            );
        }

        return $this->contexts[$name];
    }

    /**
     * Return all registered contexts.
     *
     * @return array<string, ContextInterface>
     */
    public function all(): array
    {
        return $this->contexts;
    }

    /**
     * Return the number of registered contexts.
     */
    public function count(): int
    {
        return count($this->contexts);
    }

    /**
     * Determine whether any contexts have been registered.
     */
    public function isEmpty(): bool
    {
        return empty($this->contexts);
    }
}