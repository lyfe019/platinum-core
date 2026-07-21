<?php

declare(strict_types=1);

namespace Platinum\Core\Integration\WordPress;

use Platinum\Core\Foundation\Application;

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

            $environment = $this->application->environment();

            echo '<div class="notice notice-success">';

            echo '<p>';

            echo '<strong>✅ Platinum Framework Loaded</strong><br>';

            echo 'Environment: <code>' .
                esc_html($environment) .
                '</code>';

            echo '</p>';

            echo '</div>';

        });
    }
}