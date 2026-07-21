<?php

declare(strict_types=1);

namespace Platinum\Core\Providers;

use Platinum\Core\Container\ServiceProvider;
use Platinum\Core\Support\Clock;

final class ClockServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app
            ->container()
            ->singleton(
                Clock::class,
                fn () => new Clock()
            );
    }

    public function boot(): void
    {
        //
    }
}