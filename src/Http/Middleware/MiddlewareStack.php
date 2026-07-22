<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Middleware;

/**
 * HTTP Middleware Stack.
 *
 * Owns every middleware registered with the framework.
 *
 * Middleware execute in the order they are registered.
 */
final class MiddlewareStack
{
    /**
     * Registered middleware.
     *
     * @var array<int, Middleware>
     */
    private array $middleware = [];

    /**
     * Push middleware onto the stack.
     */
    public function push(
        Middleware $middleware
    ): void {
        $this->middleware[] = $middleware;
    }

    /**
     * Return every registered middleware.
     *
     * @return array<int, Middleware>
     */
    public function all(): array
    {
        return $this->middleware;
    }

    /**
     * Determine whether any middleware
     * have been registered.
     */
    public function isEmpty(): bool
    {
        return empty($this->middleware);
    }

    /**
     * Remove all registered middleware.
     */
    public function clear(): void
    {
        $this->middleware = [];
    }

    /**
     * Return the number of registered middleware.
     */
    public function count(): int
    {
        return count($this->middleware);
    }
}