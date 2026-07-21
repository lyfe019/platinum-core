<?php

declare(strict_types=1);

namespace Platinum\Core\Integration\WordPress;

use Platinum\Core\Foundation\Application;
use Platinum\Core\Support\Clock;
use Platinum\Core\Support\ClockFormatter;

/**
 * WordPress Host Adapter
 *
 * Adapts the Platinum Core framework to the WordPress runtime.
 *
 * The framework itself knows nothing about WordPress.
 * All WordPress-specific interactions are implemented here.
 */
final class WordPressHostAdapter
{
    /**
     * The running application.
     */
    private Application $application;

    /**
     * Create a new host adapter.
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Boot the WordPress host integration.
     */
    public function boot(): void
    {
        $this->registerAdminNotice();
    }

    /**
     * Register framework verification notice.
     */
    private function registerAdminNotice(): void
    {
        add_action('admin_notices', function (): void {

            /*
            |--------------------------------------------------------------------------
            | Resolve the application's container
            |--------------------------------------------------------------------------
            */

            $container = $this->application->container();

            /*
            |--------------------------------------------------------------------------
            | Resolve ClockFormatter
            |--------------------------------------------------------------------------
            */

            $formatter = $container->make(ClockFormatter::class);

            /*
            |--------------------------------------------------------------------------
            | Display verification
            |--------------------------------------------------------------------------
            */

            echo '<div class="notice notice-success">';

            echo '<p><strong>✅ Platinum Framework Loaded</strong></p>';

            echo '<p><strong>Environment:</strong> '
                . esc_html(config('app.environment'))
                . '</p>';

            echo '<p><strong>Framework:</strong> '
                . esc_html(config('app.name'))
                . '</p>';

            echo '<p><strong>Version:</strong> '
                . esc_html(config('app.version'))
                . '</p>';

            echo '<hr>';

            echo '<p><strong>Container:</strong> Ready</p>';

            echo '<p><strong>Container Version:</strong> '
                . esc_html($container->version())
                . '</p>';

            echo '<p><strong>Clock Registered:</strong> '
                . ($container->has(Clock::class) ? 'Yes' : 'No')
                . '</p>';

            echo '<p><strong>Auto Wiring:</strong> Success</p>';

            echo '<p><strong>Resolved:</strong> '
                . esc_html(get_class($formatter))
                . '</p>';

            echo '<p><strong>Output:</strong> '
                . esc_html($formatter->formatted())
                . '</p>';

            echo '<hr>';

            echo '<p><strong>Providers Loaded:</strong> '
                . count($this->application->providers())
                . '</p>';

            echo '<p><strong>Contexts Registered:</strong> '
                . $this->application
                    ->contexts()
                    ->count()
                . '</p>';

            echo '<hr>';

            echo '<p><strong>Registered Contexts:</strong></p>';

            foreach ($this->application->contexts()->all() as $context) {

                echo '<p>&bull; '
                    . esc_html($context->name())
                    . '</p>';

                echo '<p style="margin-left:20px;"><strong>Initialized:</strong> '
                    . (
                        method_exists($context, 'initialized')
                            ? ($context->initialized() ? 'Yes' : 'No')
                            : 'Unknown'
                    )
                    . '</p>';

                echo '<p style="margin-left:20px;"><strong>Booted:</strong> '
                    . (
                        method_exists($context, 'booted')
                            ? ($context->booted() ? 'Yes' : 'No')
                            : 'Unknown'
                    )
                    . '</p>';
            }

            echo '<hr>';

            echo '<p><strong>Registry Empty:</strong> '
                . (
                    $this->application
                        ->contexts()
                        ->isEmpty()
                        ? 'Yes'
                        : 'No'
                )
                . '</p>';

            echo '<p><strong>Context Loader:</strong> Ready</p>';

            echo '<p><strong>Context Lifecycle:</strong> Completed</p>';

            echo '</div>';
        });
    }
}