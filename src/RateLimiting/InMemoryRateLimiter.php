<?php

declare(strict_types=1);

namespace Platinum\Core\RateLimiting;

use Platinum\Core\Contracts\RateLimiter;

/**
 * In-Memory Rate Limiter.
 *
 * A simple in-memory implementation of the framework
 * rate limiter contract.
 *
 * This implementation is intended for framework
 * verification and testing. Because counters are
 * stored in memory, they are reset whenever the
 * application process is restarted.
 */
final class InMemoryRateLimiter implements RateLimiter
{
    /**
     * Recorded request attempts.
     *
     * @var array<string, array{attempts:int, expires:int}>
     */
    private array $attempts = [];

    /**
     * Determine whether a request is allowed.
     */
    public function allow(
        string $key,
        int $maxAttempts,
        int $decaySeconds
    ): bool {

        $now = time();

        /*
        |--------------------------------------------------------------------------
        | Initialize or Reset Expired Window
        |--------------------------------------------------------------------------
        */

        if (
            ! isset($this->attempts[$key])
            || $this->attempts[$key]['expires'] <= $now
        ) {
            $this->attempts[$key] = [
                'attempts' => 0,
                'expires'  => $now + $decaySeconds,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Deny Requests That Exceed the Limit
        |--------------------------------------------------------------------------
        */

        if (
            $this->attempts[$key]['attempts'] >= $maxAttempts
        ) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Record the Attempt
        |--------------------------------------------------------------------------
        */

        $this->attempts[$key]['attempts']++;

        return true;
    }
}