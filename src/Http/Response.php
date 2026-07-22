<?php

declare(strict_types=1);

namespace Platinum\Core\Http;

/**
 * HTTP Response.
 *
 * Represents an outgoing HTTP response independently
 * of the underlying host environment.
 *
 * This class is intentionally immutable. Once created,
 * the response cannot be modified.
 */
final class Response
{
    /**
     * HTTP status code.
     */
    private int $status;

    /**
     * Response headers.
     *
     * @var array<string, string>
     */
    private array $headers;

    /**
     * Response body.
     */
    private mixed $body;

    /**
     * Create a new HTTP response.
     *
     * @param array<string, string> $headers
     */
    public function __construct(
        mixed $body = null,
        int $status = 200,
        array $headers = []
    ) {
        $this->body = $body;
        $this->status = $status;
        $this->headers = $headers;
    }

    /**
     * Return the response body.
     */
    public function body(): mixed
    {
        return $this->body;
    }

    /**
     * Return the HTTP status code.
     */
    public function status(): int
    {
        return $this->status;
    }

    /**
     * Return all response headers.
     *
     * @return array<string, string>
     */
    public function headers(): array
    {
        return $this->headers;
    }

    /**
     * Return a single response header.
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



    /**
 * Create a JSON response.
 *
 * @param array<string,mixed> $data
 */
public static function json(
    array $data,
    int $status = 200,
    array $headers = []
): self {
    return new self(
        body: $data,
        status: $status,
        headers: array_merge(
            [
                'Content-Type' => 'application/json',
            ],
            $headers
        ),
    );
}



   
}