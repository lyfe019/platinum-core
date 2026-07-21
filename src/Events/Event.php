<?php

declare(strict_types=1);

namespace Platinum\Core\Events;

/**
 * Base Event Contract.
 *
 * Every framework and application event implements
 * this contract.
 */
interface Event
{
    /**
     * Return the event name.
     */
    public function name(): string;

    /**
     * Return the time the event occurred.
     */
    public function occurredAt(): \DateTimeImmutable;
}