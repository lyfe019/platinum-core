<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Middleware;

use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;

/**
 * Framework Verification Middleware.
 *
 * Confirms that the middleware pipeline is executed
 * before reaching the controller.
 */
final class FrameworkVerificationMiddleware implements Middleware
{
    /**
     * Handle the incoming request.
     */
    public function handle(
        Request $request,
        Next $next
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | Continue through the pipeline
        |--------------------------------------------------------------------------
        */

        $response = $next->handle($request);

        /*
        |--------------------------------------------------------------------------
        | Decorate the outgoing response
        |--------------------------------------------------------------------------
        */

        $response->header(
            'X-Platinum-Middleware',
            'Executed'
        );

        return $response;
    }
}