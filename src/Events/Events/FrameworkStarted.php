<?php

declare(strict_types=1);

namespace Platinum\Core\Events\Events;

use DateTimeImmutable;
use Platinum\Core\Events\Event;

/**
 * Event published when the Platinum framework
 * has completed its startup lifecycle.
 */
final class FrameworkStarted implements Event
{
    /**
     * Time the event occurred.
     */
    private DateTimeImmutable $occurredAt;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        $this->occurredAt = new DateTimeImmutable();
    }

    /**
     * Return the event name.
     */
    public function name(): string
    {
        return 'FrameworkStarted';
    }

    /**
     * Return when the event occurred.
     */
    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}