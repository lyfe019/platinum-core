<?php

declare(strict_types=1);

namespace Platinum\Core\Container;

use ReflectionClass;
use ReflectionException;

final class Container
{
    /**
     * Framework version.
     */
    private string $version = '1.0.0';

    /**
     * Registered bindings.
     *
     * @var array<string, Binding>
     */
    private array $bindings = [];

    /**
     * Shared instances.
     *
     * @var array<string, object>
     */
    private array $instances = [];

    /**
     * Indicates whether the container is locked.
     */
    private bool $locked = false;

    /**
     * Register a binding.
     */
    public function bind(string $abstract, callable|string $concrete): void
    {
        $this->ensureUnlocked();

        $this->bindings[$abstract] = new Binding(
            $abstract,
            $concrete,
            false
        );
    }

    /**
     * Register a singleton.
     */
    public function singleton(string $abstract, callable|string $concrete): void
    {
        $this->ensureUnlocked();

        $this->bindings[$abstract] = new Binding(
            $abstract,
            $concrete,
            true
        );
    }

    /**
     * Register an existing instance.
     */
    public function instance(string $abstract, object $instance): void
    {
        $this->ensureUnlocked();

        $this->instances[$abstract] = $instance;
    }

    /**
     * Determine whether a service exists.
     */
    public function has(string $abstract): bool
    {
        return isset($this->bindings[$abstract])
            || isset($this->instances[$abstract]);
    }

    /**
     * Resolve a service.
     */
    public function make(string $abstract): object
    {
        return $this->resolve($abstract);
    }

    /**
     * Resolve a service.
     */
    public function resolve(string $abstract): object
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (isset($this->bindings[$abstract])) {

            $binding = $this->bindings[$abstract];

            $object = is_callable($binding->concrete)
                ? ($binding->concrete)()
                : $this->build($binding->concrete);

            if ($binding->shared) {
                $this->instances[$abstract] = $object;
            }

            return $object;
        }

        return $this->build($abstract);
    }

    /**
     * Build an object using reflection.
     */
    private function build(string $class): object
    {
        try {

            $reflection = new ReflectionClass($class);

            $constructor = $reflection->getConstructor();

            if ($constructor === null) {
                return new $class();
            }

            $dependencies = [];

            foreach ($constructor->getParameters() as $parameter) {

                $type = $parameter->getType();

                if ($type === null) {
                    throw new ContainerException(
                        "Unable to resolve {$parameter->getName()}"
                    );
                }

                $dependencies[] = $this->make(
                    $type->getName()
                );
            }

            return $reflection->newInstanceArgs($dependencies);

        } catch (ReflectionException $exception) {

            throw new NotFoundException(
                $exception->getMessage()
            );

        }
    }

    /**
     * Remove a service.
     */
    public function forget(string $abstract): void
    {
        unset($this->bindings[$abstract]);
        unset($this->instances[$abstract]);
    }

    /**
     * Remove everything.
     */
    public function flush(): void
    {
        $this->bindings = [];
        $this->instances = [];
    }

    /**
     * Lock the container.
     */
    public function lock(): void
    {
        $this->locked = true;
    }

    /**
     * Determine whether the container is locked.
     */
    public function isLocked(): bool
    {
        return $this->locked;
    }

    /**
     * Framework version.
     */
    public function version(): string
    {
        return $this->version;
    }

    /**
     * Prevent modifications once locked.
     */
    private function ensureUnlocked(): void
    {
        if ($this->locked) {
            throw new ContainerException(
                'The container has been locked.'
            );
        }
    }
}