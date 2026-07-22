<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Middleware;

use Platinum\Core\Contracts\RateLimiter;
use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;

/**
 * HTTP Rate Limiting Middleware.
 *
 * Prevents excessive requests by consulting the framework
 * rate limiter before allowing execution to continue.
 */
final class RateLimitingMiddleware implements Middleware
{
    /**
     * Maximum number of requests allowed.
     */
    private const MAX_ATTEMPTS = 5;

    /**
     * Time window, in seconds.
     */
    private const DECAY_SECONDS = 60;

    /**
     * Create a new rate limiting middleware.
     */
    public function __construct(
        private RateLimiter $limiter
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
        | Build Request Key
        |--------------------------------------------------------------------------
        |
        | For now, rate limiting is performed using the client IP address.
        | This can later evolve to use an authenticated actor, API key,
        | or another identifier without changing the middleware.
        |
        */

        $key = $request->ip();

        /*
        |--------------------------------------------------------------------------
        | Check Rate Limit
        |--------------------------------------------------------------------------
        */

        if (! $this->limiter->allow(
            $key,
            self::MAX_ATTEMPTS,
            self::DECAY_SECONDS
        )) {
            return Response::json(
                [
                    'message' => 'Too Many Requests',
                ],
                429
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Continue Pipeline
        |--------------------------------------------------------------------------
        */

        return $next->handle($request);
    }
}