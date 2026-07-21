<?php

declare(strict_types=1);

namespace Platinum\Core\Events;

/**
 * Dispatches events to registered listeners.
 */
final class Dispatcher
{
    /**
     * Listener registry.
     */
    private ListenerRegistry $registry;

    /**
     * Create a new dispatcher.
     */
    public function __construct(
        ListenerRegistry $registry
    ) {
        $this->registry = $registry;
    }

    /**
     * Dispatch an event.
     */
    public function dispatch(Event $event): void
    {
        foreach (
            $this->registry->listeners($event::class)
            as $registration
        ) {

            $listener = new $registration['listener']();

            $method = $registration['method'];

            $listener->{$method}($event);
        }
    }

    /**
     * Return the listener registry.
     */
    public function registry(): ListenerRegistry
    {
        return $this->registry;
    }
}