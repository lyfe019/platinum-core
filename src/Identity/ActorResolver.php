<?php

declare(strict_types=1);

namespace Platinum\Core\Identity;

/**
 * Actor Resolver.
 *
 * Resolves the identity responsible for the current
 * request.
 *
 * The resolver adapts the current host authentication
 * mechanism into the framework's Actor abstraction.
 *
 * Under WordPress, authenticated users are translated
 * into AuthenticatedActor instances. When no user is
 * authenticated—or when the framework is running
 * outside of WordPress—the resolver returns an
 * AnonymousActor.
 */
final class ActorResolver
{
    /**
     * Resolve the current actor.
     */
    public function resolve(): Actor
    {
        /*
        |--------------------------------------------------------------------------
        | Host Environment
        |--------------------------------------------------------------------------
        |
        | If the framework is executing outside of WordPress,
        | authentication cannot be resolved. Treat the request
        | as anonymous.
        |
        */

        if (
            ! function_exists('is_user_logged_in')
            || ! function_exists('wp_get_current_user')
        ) {
            return new AnonymousActor();
        }

        /*
        |--------------------------------------------------------------------------
        | Anonymous User
        |--------------------------------------------------------------------------
        */

        if (! is_user_logged_in()) {
            return new AnonymousActor();
        }

        /*
        |--------------------------------------------------------------------------
        | Resolve Current WordPress User
        |--------------------------------------------------------------------------
        */

        $user = wp_get_current_user();

        error_log(
    sprintf(
        'Logged In: %s | User ID: %d',
        is_user_logged_in() ? 'yes' : 'no',
        $user->ID ?? 0
    )
);

        /*
        |--------------------------------------------------------------------------
        | Invalid User
        |--------------------------------------------------------------------------
        */

        if (
            ! isset($user->ID)
            || (int) $user->ID <= 0
        ) {
            return new AnonymousActor();
        }

        /*
        |--------------------------------------------------------------------------
        | Authenticated Actor
        |--------------------------------------------------------------------------
        */

        return new AuthenticatedActor(
            (string) $user->ID
        );
    }
}