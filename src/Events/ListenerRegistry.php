<?php

declare(strict_types=1);

namespace Platinum\Core\Events;

/**
 * Stores event listener registrations.
 */
final class ListenerRegistry
{
    /**
     * Registered listeners.
     *
     * @var array<string, array<int, array{
     *     listener: class-string,
     *     method: string
     * }>>
     */
    private array $listeners = [];

    /**
     * Register a listener.
     *
     * @param class-string<Event> $event
     * @param class-string        $listener
     */
    public function listen(
        string $event,
        string $listener,
        string $method
    ): void {
        $this->listeners[$event][] = [
            'listener' => $listener,
            'method'   => $method,
        ];
    }

    /**
     * Register all listeners from a subscriber.
     */
    public function registerSubscriber(
        string $subscriber
    ): void {
        foreach ($subscriber::subscribe() as $event => $handler) {

            $this->listen(
                $event,
                $handler['listener'],
                $handler['method']
            );
        }
    }

    /**
     * Return listeners for an event.
     *
     * @return array<int, array{
     *     listener: class-string,
     *     method: string
     * }>
     */
    public function listeners(string $event): array
    {
        return $this->listeners[$event] ?? [];
    }

    /**
     * Determine whether an event has listeners.
     */
    public function has(string $event): bool
    {
        return isset($this->listeners[$event]);
    }

    /**
     * Return all registrations.
     *
     * @return array<string, array<int, array{
     *     listener: class-string,
     *     method: string
     * }>>
     */
    public function all(): array
    {
        return $this->listeners;
    }

    /**
     * Number of registered events.
     */
    public function count(): int
    {
        return count($this->listeners);
    }

    /**
     * Determine whether the registry is empty.
     */
    public function isEmpty(): bool
    {
        return empty($this->listeners);
    }
}