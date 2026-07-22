<?php

declare(strict_types=1);

namespace Platinum\Core\Contracts;

/**
 * Rate Limiter Contract.
 *
 * Defines the framework interface for rate limiting
 * incoming HTTP requests.
 *
 * Implementations determine whether a request should
 * be allowed to proceed based on a unique key, the
 * maximum number of permitted attempts, and the
 * configured decay period.
 */
interface RateLimiter
{
    /**
     * Determine whether a request is allowed.
     *
     * The implementation should record the attempt if
     * the request is permitted. If the maximum number
     * of attempts has already been reached within the
     * decay period, the request should be denied.
     *
     * @param string $key A unique identifier for the requester
     *                    (for example, an IP address, actor ID,
     *                    or API key).
     * @param int $maxAttempts Maximum allowed requests during
     *                         the decay period.
     * @param int $decaySeconds Length of the rate limiting window
     *                          in seconds.
     */
    public function allow(
        string $key,
        int $maxAttempts,
        int $decaySeconds
    ): bool;
}