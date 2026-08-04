<?php

declare(strict_types=1);

namespace Platinum\Core\Integration\WordPress;

use Platinum\Core\Scheduling\Contracts\SchedulerInterface;

/**
 * Host adapter connecting Platinum framework task scheduler to WordPress WP-Cron.
 */
final class WordPressCronAdapter
{
    private const CRON_ACTION_HOOK = 'platinum_core_scheduled_tasks_runner';

    private SchedulerInterface $scheduler;

    public function __construct(SchedulerInterface $scheduler)
    {
        $this->scheduler = $scheduler;
    }

    /**
     * Boot the WP Cron hooks.
     */
    public function boot(): void
    {
        if (function_exists('add_action')) {
            add_action(self::CRON_ACTION_HOOK, [$this, 'executeScheduledTasks']);
            $this->ensureScheduledEvent();
        }
    }

    /**
     * Triggers scheduler task evaluation when WP-Cron fires.
     */
    public function executeScheduledTasks(): void
    {
        $this->scheduler->runDue();
    }

    /**
     * Ensures the core runner hook exists in WP Cron schedule.
     */
    private function ensureScheduledEvent(): void
    {
        if (function_exists('wp_next_scheduled') && function_exists('wp_schedule_event')) {
            if (!wp_next_scheduled(self::CRON_ACTION_HOOK)) {
                wp_schedule_event(time(), 'hourly', self::CRON_ACTION_HOOK);
            }
        }
    }
}