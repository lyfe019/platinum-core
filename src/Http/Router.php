<?php

declare(strict_types=1);

namespace Platinum\Core\Http;

/**
 * HTTP Router.
 *
 * Stores all routes registered with the framework.
 *
 * The router is responsible for:
 * - Registering routes
 * - Returning registered routes
 * - Matching an incoming request to a route
 *
 * Controller execution and middleware dispatching
 * are implemented in later phases.
 */
final class Router
{
    /**
     * Registered routes.
     *
     * @var array<int, Route>
     */
    private array $routes = [];

    /**
     * Register a route.
     */
    public function add(Route $route): void
    {
        $this->routes[] = $route;
    }

    /**
     * Register a GET route.
     */
    public function get(
        string $uri,
        string $action
    ): void {
        $this->add(
            new Route(
                'GET',
                $uri,
                $action
            )
        );
    }

    /**
     * Register a POST route.
     */
    public function post(
        string $uri,
        string $action
    ): void {
        $this->add(
            new Route(
                'POST',
                $uri,
                $action
            )
        );
    }

    /**
     * Attempt to match a registered route.
     *
     * Returns the matching route or null if no
     * route matches the supplied HTTP method and URI.
     */
    public function match(
        string $method,
        string $uri
    ): ?Route {
        $method = strtoupper($method);

        foreach ($this->routes as $route) {

            if (
                $route->method() === $method &&
                $route->uri() === $uri
            ) {
                return $route;
            }
        }

        return null;
    }

    /**
     * Return all registered routes.
     *
     * @return array<int, Route>
     */
    public function routes(): array
    {
        return $this->routes;
    }
}