<?php

declare(strict_types=1);

namespace Platinum\Core\Foundation;

use Platinum\Core\Container\Container;
use Platinum\Core\Container\ServiceProvider;

final class Application
{
    /**
     * Runtime environment.
     */
    private string $environment;

    /**
     * Service container.
     */
    private Container $container;

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
    }

    /**
     * Return the environment.
     */
    public function environment(): string
    {
        return $this->environment;
    }

    /**
     * Return the service container.
     */
    public function container(): Container
    {
        return $this->container;
    }

    /**
     * Register a service provider.
     */
    public function register(ServiceProvider $provider): self
    {
        $provider->register();

        $this->providers[] = $provider;

        return $this;
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