<?php

declare(strict_types=1);

namespace Platinum\Core\Identity;

/**
 * Actor Resolver.
 *
 * Resolves the identity responsible for the current
 * request.
 *
 * The resolver currently returns an AnonymousActor for
 * every request. Future implementations will integrate
 * with the host environment (such as WordPress),
 * authentication providers, API keys, JWTs, or other
 * identity mechanisms without affecting the rest of the
 * framework.
 */
final class ActorResolver
{
    /**
     * Resolve the current actor.
     */
    public function resolve(): Actor
    {
        return new AnonymousActor();
    }
}