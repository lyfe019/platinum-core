<?php

declare(strict_types=1);

namespace Platinum\Core\RateLimiting;

use Platinum\Core\Contracts\RateLimiter;

/**
 * In-Memory Rate Limiter.
 *
 * Stores request counters in memory for the lifetime of
 * the current PHP process.
 *
 * This implementation is intended for framework
 * verification and development. It can later be replaced
 * with Redis, database, cache, or WordPress transients
 * without changing any middleware.
 */
final class InMemoryRateLimiter implements RateLimiter
{
    /**
     * Request attempts.
     *
     * @var array<string, array{attempts:int, expires:int}>
     */
    private array $attempts = [];

    /**
     * Determine whether the request is allowed.
     */
    public function allow(
        string $key,
        int $maxAttempts,
        int $decaySeconds
    ): bool {

        $now = time();

        /*
        |--------------------------------------------------------------------------
        | Create New Entry
        |--------------------------------------------------------------------------
        */

        if (! isset($this->attempts[$key])) {

            $this->attempts[$key] = [
                'attempts' => 1,
                'expires' => $now + $decaySeconds,
            ];

            return true;
        }

        $entry = &$this->attempts[$key];

        /*
        |--------------------------------------------------------------------------
        | Reset Expired Window
        |--------------------------------------------------------------------------
        */

        if ($entry['expires'] <= $now) {

            $entry = [
                'attempts' => 1,
                'expires' => $now + $decaySeconds,
            ];

            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Reject Requests Above Limit
        |--------------------------------------------------------------------------
        */

        if ($entry['attempts'] >= $maxAttempts) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Increment Attempts
        |--------------------------------------------------------------------------
        */

        $entry['attempts']++;

        return true;
    }
}