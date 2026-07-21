<?php

declare(strict_types=1);

namespace Platinum\Core\Providers;

use Platinum\Core\Container\ServiceProvider;
use Platinum\Core\Events\Dispatcher;
use Platinum\Core\Events\EventBus;
use Platinum\Core\Events\ListenerRegistry;
use Platinum\Core\Events\Subscribers\FrameworkSubscriber;

/**
 * Event Service Provider.
 *
 * Registers the framework event subsystem.
 */
final class EventServiceProvider extends ServiceProvider
{
    /**
     * Register event services.
     */
    public function register(): void
    {
        $registry = new ListenerRegistry();

        /*
        |--------------------------------------------------------------------------
        | Register Framework Subscribers
        |--------------------------------------------------------------------------
        */

        $registry->registerSubscriber(
            FrameworkSubscriber::class
        );

        /*
        |--------------------------------------------------------------------------
        | Register Core Event Services
        |--------------------------------------------------------------------------
        */

        $dispatcher = new Dispatcher($registry);

        $bus = new EventBus($dispatcher);

        $this->app
            ->container()
            ->singleton(
                ListenerRegistry::class,
                fn () => $registry
            );

        $this->app
            ->container()
            ->singleton(
                Dispatcher::class,
                fn () => $dispatcher
            );

        $this->app
            ->container()
            ->singleton(
                EventBus::class,
                fn () => $bus
            );
    }

    /**
     * Boot event services.
     */
    public function boot(): void
    {
        //
    }
}