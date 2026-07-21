<?php

declare(strict_types=1);

namespace Platinum\Core\Foundation;

use Platinum\Core\Container\Container;
use Platinum\Core\Container\ServiceProvider;
use Platinum\Core\Contexts\ContextLoader;
use Platinum\Core\Contexts\ContextRegistry;

/**
 * Represents the running Platinum application.
 */
final class Application
{
    /**
     * Current runtime environment.
     */
    private string $environment;

    /**
     * Service container.
     */
    private Container $container;

    /**
     * Registered bounded contexts.
     */
    private ContextRegistry $contexts;

    /**
     * Context loader.
     */
    private ContextLoader $contextLoader;

    /**
     * Registered service providers.
     *
     * @var array<int, ServiceProvider>
     */
    private array $providers = [];

    /**
     * Create the application.
     */
    public function __construct()
    {
        $this->environment = Environment::current();

        $this->container = new Container();

        $this->contexts = new ContextRegistry();

        $this->contextLoader = new ContextLoader($this);
    }

    /**
     * Get the current environment.
     */
    public function environment(): string
    {
        return $this->environment;
    }

    /**
     * Get the service container.
     */
    public function container(): Container
    {
        return $this->container;
    }

    /**
     * Get the context registry.
     */
    public function contexts(): ContextRegistry
    {
        return $this->contexts;
    }

    /**
     * Get the context loader.
     */
    public function contextLoader(): ContextLoader
    {
        return $this->contextLoader;
    }

    /**
     * Register a service provider.
     */
    public function register(ServiceProvider $provider): static
    {
        $this->providers[] = $provider;

        $provider->register();

        return $this;
    }

    /**
     * Get all registered providers.
     *
     * @return array<int, ServiceProvider>
     */
    public function providers(): array
    {
        return $this->providers;
    }

    /**
     * Boot all registered providers.
     */
    public function bootProviders(): void
    {
        foreach ($this->providers as $provider) {
            $provider->boot();
        }
    }
}