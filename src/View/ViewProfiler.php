<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Profiles template rendering performance metrics.
 */
final class ViewProfiler
{
    /** @var array<int, array<string, mixed>> */
    private array $profiles = [];
    /** @var array<string, mixed>|null */
    private ?array $activeProfile = null;

    /**
     * Start profiling a view rendering cycle.
     */
    public function start(string $viewName): void
    {
        $this->activeProfile = [
            'view' => $viewName,
            'start_time' => microtime(true),
            'start_memory' => memory_get_usage(true),
        ];
    }

    /**
     * Stop profiling current rendering cycle and record metrics.
     */
    public function stop(): void
    {
        if ($this->activeProfile === null) {
            return;
        }

        $endTime = microtime(true);
        $endMemory = memory_get_usage(true);

        $this->profiles[] = [
            'view' => $this->activeProfile['view'],
            'duration_ms' => round(($endTime - $this->activeProfile['start_time']) * 1000, 2),
            'memory_bytes' => $endMemory - $this->activeProfile['start_memory'],
            'peak_memory_bytes' => memory_get_peak_usage(true),
        ];

        $this->activeProfile = null;
    }

    /**
     * Returns all recorded render profiles.
     *
     * @return array<int, array<string, mixed>>
     */
    public function profiles(): array
    {
        return $this->profiles;
    }

    /**
     * Total elapsed time across all profiled view renderings in milliseconds.
     */
    public function totalDurationMs(): float
    {
        return array_reduce(
            $this->profiles,
            static fn (float $sum, array $p): float => $sum + (float) $p['duration_ms'],
            0.0
        );
    }
}