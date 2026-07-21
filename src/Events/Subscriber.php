<?php

declare(strict_types=1);

namespace Platinum\Core\Events;

/**
 * Event Subscriber Contract.
 *
 * Subscribers declare the events they are interested in.
 * The framework is responsible for registering those
 * subscriptions with the ListenerRegistry.
 *
 * Example:
 *
 * final class FrameworkSubscriber implements Subscriber
 * {
 *     public static function subscribe(): array
 *     {
 *         return [
 *             FrameworkStarted::class => 'onFrameworkStarted',
 *         ];
 *     }
 *
 *     public function onFrameworkStarted(
 *         FrameworkStarted $event
 *     ): void
 *     {
 *         // Handle the event...
 *     }
 * }
 */
interface Subscriber
{
    /**
     * Return the events handled by this subscriber.
     *
     * The returned array maps event class names
     * to the subscriber method that should be invoked.
     *
     * Example:
     *
     * [
     *     FrameworkStarted::class => 'onFrameworkStarted',
     * ]
     *
     * @return array<class-string<Event>, string>
     */
    public static function subscribe(): array;
}