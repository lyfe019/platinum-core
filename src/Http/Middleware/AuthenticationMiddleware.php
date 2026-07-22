<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Middleware;

use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;

/**
 * HTTP Authentication Middleware.
 *
 * Responsible for authenticating the current request
 * before it reaches the application.
 *
 * At this stage, the middleware acts as a placeholder
 * within the middleware pipeline. Authentication logic
 * will be introduced in Phase 11 when the Identity
 * subsystem is implemented.
 */
final class AuthenticationMiddleware implements Middleware
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
        | Authentication
        |--------------------------------------------------------------------------
        |
        | Authentication is not yet implemented. For now, every request
        | is allowed to continue through the middleware pipeline.
        | The Identity subsystem introduced in Phase 11 will resolve
        | the current actor and enforce authentication where required.
        |
        */

        return $next->handle($request);
    }
}