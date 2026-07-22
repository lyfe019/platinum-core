<?php

declare(strict_types=1);

namespace Platinum\Core\Http;

/**
 * HTTP Response.
 *
 * Represents an outgoing HTTP response.
 */
final class Response
{
    /**
     * Response body.
     */
    private mixed $body;

    /**
     * Status code.
     */
    private int $status;

    /**
     * Response headers.
     *
     * @var array<string,string>
     */
    private array $headers = [];

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
     * Create JSON response.
     */
    public static function json(
        array $data,
        int $status = 200
    ): self {
        return new self(
            $data,
            $status,
            [
                'Content-Type' => 'application/json',
            ]
        );
    }

    /**
     * Add or replace a response header.
     */
    public function header(
        string $name,
        string $value
    ): self {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Return headers.
     *
     * @return array<string,string>
     */
    public function headers(): array
    {
        return $this->headers;
    }

    /**
     * Return body.
     */
    public function body(): mixed
    {
        return $this->body;
    }

    /**
     * Return status.
     */
    public function status(): int
    {
        return $this->status;
    }
}