<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Middleware;

use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;
use Throwable;

/**
 * Exception Middleware.
 *
 * Converts uncaught exceptions into consistent HTTP
 * responses, preventing framework internals from
 * leaking to the client.
 *
 * This middleware should be the first middleware
 * registered so that it wraps the entire request
 * pipeline.
 */
final class ExceptionMiddleware implements Middleware
{
    /**
     * Handle the incoming request.
     */
    public function handle(
        Request $request,
        Next $next
    ): Response {

        try {

            /*
            |--------------------------------------------------------------------------
            | Continue through the pipeline
            |--------------------------------------------------------------------------
            */

            return $next->handle($request);

        } catch (Throwable $exception) {

    return Response::json(
        [
            'message' => $exception->getMessage(),
            'exception' => get_class($exception),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ],
        500
    );
}

           
    }
}