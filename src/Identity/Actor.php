<?php

declare(strict_types=1);

namespace Platinum\Core\Identity;

/**
 * Framework Actor.
 *
 * Represents the identity responsible for the
 * current request.
 */
interface Actor
{
    /**
     * Return the unique actor identifier.
     */
    public function id(): ?string;

    /**
     * Determine whether the actor is authenticated.
     */
    public function authenticated(): bool;
}