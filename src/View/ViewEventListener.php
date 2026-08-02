<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Interface for presentation layer event listeners.
 */
interface ViewEventListener
{
    /**
     * Handle an emitted ViewEvent.
     */
    public function handle(ViewEvent $event): void;

    /**
     * Returns the list of event names this listener subscribes to.
     *
     * @return string[]
     */
    public function subscribedEvents(): array;
}