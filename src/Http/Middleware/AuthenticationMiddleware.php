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
 * The middleware resolves the current actor and
 * attaches it to the immutable request before
 * allowing execution to continue.
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
        | The resolver currently returns an AnonymousActor for every
        | request. Future implementations will resolve authenticated
        | actors from the host environment.
        |
        */

        $actor = $this->resolver->resolve();

        /*
        |--------------------------------------------------------------------------
        | Attach Actor
        |--------------------------------------------------------------------------
        |
        | Preserve request immutability by creating a new request
        | instance that carries the resolved actor.
        |
        */

        $request = $request->withActor($actor);

        /*
        |--------------------------------------------------------------------------
        | Continue Pipeline
        |--------------------------------------------------------------------------
        */

        return $next->handle($request);
    }
}