<?php

declare(strict_types=1);

namespace Platinum\Core\Events;

/**
 * Event Bus.
 *
 * Responsible for publishing domain events.
 */
final class EventBus
{
    /**
     * Dispatcher.
     */
    private Dispatcher $dispatcher;

    /**
     * Create a new event bus.
     */
    public function __construct(
        Dispatcher $dispatcher
    ) {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Publish an event.
     */
    public function publish(Event $event): void
    {
        $this->dispatcher->dispatch($event);
    }

    /**
     * Return the dispatcher.
     */
    public function dispatcher(): Dispatcher
    {
        return $this->dispatcher;
    }
}