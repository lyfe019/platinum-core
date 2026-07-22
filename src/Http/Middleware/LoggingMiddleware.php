<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Middleware;

use Platinum\Core\Contracts\Logger;
use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;

/**
 * HTTP Logging Middleware.
 *
 * Records information about every HTTP request handled
 * by the framework.
 */
final class LoggingMiddleware implements Middleware
{
    /**
     * Create a new logging middleware instance.
     */
    public function __construct(
        private Logger $logger
    ) {
    }

    /**
     * Handle the incoming request.
     */
    public function handle(
        Request $request,
        Next $next
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | Record Request Start Time
        |--------------------------------------------------------------------------
        */

        $start = microtime(true);

        /*
        |--------------------------------------------------------------------------
        | Continue Through Pipeline
        |--------------------------------------------------------------------------
        */

        $response = $next->handle($request);

        /*
        |--------------------------------------------------------------------------
        | Calculate Request Duration
        |--------------------------------------------------------------------------
        */

        $duration = round(
            (microtime(true) - $start) * 1000,
            2
        );

        /*
        |--------------------------------------------------------------------------
        | Log Request Information
        |--------------------------------------------------------------------------
        */

        $this->logger->info(
            'HTTP Request',
            [
                'method' => $request->method(),
                'uri' => $request->uri(),
                'duration_ms' => $duration,
            ]
        );

        return $response;
    }
}