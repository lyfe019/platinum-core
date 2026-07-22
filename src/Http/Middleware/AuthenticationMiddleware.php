<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Middleware;

use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;
use Platinum\Core\Identity\ActorResolver;

/**
 * HTTP Authentication Middleware.
 *
 * Responsible for resolving the identity responsible
 * for the current request before it reaches the
 * application.
 *
 * Authorization is not performed at this stage.
 * The resolved actor will be attached to the request
 * in the next phase of the Identity subsystem.
 */
final class AuthenticationMiddleware implements Middleware
{
    /**
     * Create a new authentication middleware.
     */
    public function __construct(
        private readonly ActorResolver $resolver
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
        | Resolve Current Actor
        |--------------------------------------------------------------------------
        |
        | Resolve the identity responsible for the current request.
        | At this stage, the resolver always returns an
        | AnonymousActor. The actor will be attached to the
        | request in the next phase.
        |
        */

        $actor = $this->resolver->resolve();

        /*
        |--------------------------------------------------------------------------
        | Continue Pipeline
        |--------------------------------------------------------------------------
        */

        return $next->handle($request);
    }
}