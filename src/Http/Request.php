<?php

declare(strict_types=1);

namespace Platinum\Core\Http;

/**
 * HTTP Request.
 *
 * Represents an incoming HTTP request independently
 * of the underlying host environment.
 *
 * This class is intentionally immutable. Once created,
 * the request cannot be modified.
 */
final class Request
{
    /**
     * HTTP request method.
     */
    private string $method;

    /**
     * Request URI.
     */
    private string $uri;

    /**
     * Query parameters.
     *
     * @var array<string, mixed>
     */
    private array $query;

    /**
     * Request body.
     *
     * @var array<string, mixed>
     */
    private array $body;

    /**
     * HTTP headers.
     *
     * @var array<string, string>
     */
    private array $headers;

    /**
     * Create a new HTTP request.
     *
     * @param array<string, mixed>  $query
     * @param array<string, mixed>  $body
     * @param array<string, string> $headers
     */
    public function __construct(
        string $method,
        string $uri,
        array $query = [],
        array $body = [],
        array $headers = []
    ) {
        $this->method = strtoupper($method);
        $this->uri = $uri;
        $this->query = $query;
        $this->body = $body;
        $this->headers = $headers;
    }

    /**
     * Return the HTTP method.
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * Return the request URI.
     */
    public function uri(): string
    {
        return $this->uri;
    }

    /**
     * Return all query parameters.
     *
     * @return array<string, mixed>
     */
    public function query(): array
    {
        return $this->query;
    }

    /**
     * Return a query parameter.
     */
    public function queryParameter(
        string $key,
        mixed $default = null
    ): mixed {
        return $this->query[$key] ?? $default;
    }

    /**
     * Return the request body.
     *
     * @return array<string, mixed>
     */
    public function body(): array
    {
        return $this->body;
    }

    /**
     * Return a body parameter.
     */
    public function input(
        string $key,
        mixed $default = null
    ): mixed {
        return $this->body[$key] ?? $default;
    }

    /**
     * Return all HTTP headers.
     *
     * @return array<string, string>
     */
    public function headers(): array
    {
        return $this->headers;
    }

    /**
     * Return a single HTTP header.
     */
    public function header(
        string $name,
        ?string $default = null
    ): ?string {
        return $this->headers[$name] ?? $default;
    }

    /**
     * Determine whether a header exists.
     */
    public function hasHeader(string $name): bool
    {
        return array_key_exists($name, $this->headers);
    }
}