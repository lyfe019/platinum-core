<?php

declare(strict_types=1);

namespace Platinum\Core\Identity;

/**
 * Authenticated Actor.
 *
 * Represents an authenticated identity.
 */
final class AuthenticatedActor implements Actor
{
    /**
     * Create a new authenticated actor.
     */
    public function __construct(
        private readonly string $id,
    ) {
    }

    /**
     * Return the actor identifier.
     */
    public function id(): ?string
    {
        return $this->id;
    }

    /**
     * Determine whether the actor is authenticated.
     */
    public function authenticated(): bool
    {
        return true;
    }
}