<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Middleware;

use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;

/**
 * Middleware Pipeline Continuation.
 *
 * Executes middleware one at a time until the
 * destination callback is reached.
 */
final class PipelineNext implements Next
{
    /**
     * @var array<int, Middleware>
     */
    private array $middleware;

    /**
     * Current middleware index.
     */
    private int $index;

    /**
     * Final destination.
     *
     * @var callable(Request): Response
     */
    private $destination;

    /**
     * Create a new continuation.
     *
     * @param array<int, Middleware> $middleware
     * @param callable(Request): Response $destination
     */
    public function __construct(
        array $middleware,
        callable $destination,
        int $index = 0,
    ) {
        $this->middleware = $middleware;
        $this->destination = $destination;
        $this->index = $index;
    }

    /**
     * Continue pipeline execution.
     */
    public function handle(
        Request $request
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | End of pipeline
        |--------------------------------------------------------------------------
        */

        if (! isset($this->middleware[$this->index])) {
            return ($this->destination)($request);
        }

        /*
        |--------------------------------------------------------------------------
        | Execute current middleware
        |--------------------------------------------------------------------------
        */

        $middleware = $this->middleware[$this->index];

        $next = new self(
            $this->middleware,
            $this->destination,
            $this->index + 1,
        );

        return $middleware->handle(
            $request,
            $next,
        );
    }
}