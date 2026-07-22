<?php

declare(strict_types=1);

namespace Platinum\Core\Http;

/**
 * HTTP Route.
 *
 * Describes a single HTTP route within the framework.
 *
 * A route consists of:
 * - HTTP method
 * - URI
 * - Action
 *
 * The route is intentionally immutable.
 */
final class Route
{
    /**
     * HTTP method.
     */
    private string $method;

    /**
     * Route URI.
     */
    private string $uri;

    /**
     * Route action.
     *
     * Typically a controller class name.
     */
    private string $action;

    /**
     * Create a new route.
     */
    public function __construct(
        string $method,
        string $uri,
        string $action
    ) {
        $this->method = strtoupper($method);
        $this->uri = $uri;
        $this->action = $action;
    }

    /**
     * Return the HTTP method.
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * Return the route URI.
     */
    public function uri(): string
    {
        return $this->uri;
    }

    /**
     * Return the route action.
     */
    public function action(): string
    {
        return $this->action;
    }
}