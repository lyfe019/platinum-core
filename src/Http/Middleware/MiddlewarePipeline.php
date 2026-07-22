<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Middleware;

use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;

/**
 * HTTP Middleware Pipeline.
 *
 * Executes middleware in the order they were registered
 * before finally invoking the destination callback.
 */
final class MiddlewarePipeline
{
    /**
     * Execute the middleware pipeline.
     *
     * @param array<int, Middleware> $middleware
     * @param callable(Request): Response $destination
     */
    public function process(
        Request $request,
        array $middleware,
        callable $destination
    ): Response {

        $next = new PipelineNext(
            $middleware,
            $destination
        );

        return $next->handle($request);
    }
}