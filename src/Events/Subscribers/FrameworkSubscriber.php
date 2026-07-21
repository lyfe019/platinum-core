<?php

declare(strict_types=1);

namespace Platinum\Core\Events\Subscribers;

use Platinum\Core\Events\Events\FrameworkStarted;
use Platinum\Core\Events\Listeners\FrameworkStartedListener;
use Platinum\Core\Events\Subscriber;

/**
 * Registers the framework event listeners.
 */
final class FrameworkSubscriber implements Subscriber
{
    /**
     * Return the framework event subscriptions.
     *
     * @return array<string, array{
     *     listener: class-string,
     *     method: string
     * }>
     */
    public static function subscribe(): array
    {
        return [
            FrameworkStarted::class => [
                'listener' => FrameworkStartedListener::class,
                'method'   => 'onFrameworkStarted',
            ],
        ];
    }
}