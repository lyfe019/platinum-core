<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Middleware;

use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;

/**
 * HTTP Middleware Contract.
 *
 * Middleware intercepts an incoming request before it
 * reaches the controller and may also modify the outgoing
 * response before it is returned to the host.
 */
interface Middleware
{
    /**
     * Handle the incoming request.
     *
     * Returning the result of $next->handle($request)
     * passes execution to the next middleware in the
     * pipeline.
     */
    public function handle(
        Request $request,
        Next $next
    ): Response;
}