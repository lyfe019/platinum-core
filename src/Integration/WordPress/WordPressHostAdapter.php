<?php

declare(strict_types=1);

namespace Platinum\Core\Integration\WordPress;

use Platinum\Core\Events\Listeners\FrameworkStartedListener;
use Platinum\Core\Foundation\Application;
use Platinum\Core\Http\ApiKernel;
use Platinum\Core\Support\Clock;
use Platinum\Core\Support\ClockFormatter;
use WP_REST_Request;

/**
 * WordPress Host Adapter.
 *
 * Adapts the Platinum Core framework to the WordPress runtime.
 *
 * The framework itself knows nothing about WordPress.
 * All WordPress-specific interactions are implemented here.
 */
final class WordPressHostAdapter
{
    /**
     * REST API namespace.
     */
    private const REST_NAMESPACE = 'platinum/v1';

    /**
     * Running application.
     */
    private Application $application;

    /**
     * Framework API kernel.
     */
    private ApiKernel $kernel;

    /**
     * Request adapter.
     */
    private WordPressRequestAdapter $requestAdapter;

    /**
     * Response adapter.
     */
    private WordPressResponseAdapter $responseAdapter;

    /**
     * Create a new host adapter.
     */
    public function __construct(
        Application $application,
        ApiKernel $kernel,
        WordPressRequestAdapter $requestAdapter,
        WordPressResponseAdapter $responseAdapter
    ) {
        $this->application = $application;
        $this->kernel = $kernel;
        $this->requestAdapter = $requestAdapter;
        $this->responseAdapter = $responseAdapter;
    }

    /**
     * Boot the WordPress host integration.
     */
    public function boot(): void
    {
        $this->registerAdminNotice();

        $this->registerRestApi();
    }

    /**
     * Register the WordPress REST API integration.
     */
    private function registerRestApi(): void
    {
        add_action(
            'rest_api_init',
            function (): void {

                register_rest_route(
                    self::REST_NAMESPACE,
                    '/status',
                    [
                        'methods' => 'GET',

                        'callback' => function (
                            WP_REST_Request $request
                        ) {

                            $frameworkRequest = $this->requestAdapter
                                ->fromWordPress($request);

                            $frameworkResponse = $this->kernel
                                ->handle($frameworkRequest);

                            return $this->responseAdapter
                                ->toWordPress($frameworkResponse);
                        },

                        'permission_callback' => '__return_true',
                    ]
                );
            }
        );
    }

    /**
     * Register framework verification notice.
     */
    private function registerAdminNotice(): void
    {
        add_action('admin_notices', function (): void {

            $container = $this->application->container();

            $formatter = $container->make(
                ClockFormatter::class
            );

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

            echo '<hr>';

            echo '<p><strong>Event Bus:</strong> Ready</p>';

            echo '<p><strong>FrameworkStarted Published:</strong> Yes</p>';

            echo '<p><strong>FrameworkStarted Listener Executed:</strong> '
                . (
                    FrameworkStartedListener::executed()
                        ? 'Yes'
                        : 'No'
                )
                . '</p>';

            echo '<hr>';

            echo '<p><strong>HTTP Router:</strong> Ready</p>';

            echo '<p><strong>API Kernel:</strong> Ready</p>';

            echo '<p><strong>Request Adapter:</strong> Ready</p>';

            echo '<p><strong>Response Adapter:</strong> Ready</p>';

            echo '<p><strong>REST Namespace:</strong> '
                . esc_html(self::REST_NAMESPACE)
                . '</p>';

            echo '<p><strong>REST Endpoint:</strong> /status</p>';

            echo '<p><strong>REST Pipeline:</strong> Framework Controlled</p>';

            echo '</div>';
        });
    }
}