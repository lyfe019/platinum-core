<?php

declare(strict_types=1);

namespace Platinum\Core\Integration\WordPress;

use Platinum\Core\Console\Contracts\ConsoleKernelInterface;
use Platinum\Core\Console\Input;
use Platinum\Core\Console\Output;
use WP_CLI;

/**
 * WP-CLI Adapter connecting Platinum Core CLI commands into native WP-CLI command tree.
 */
final class WpCliAdapter
{
    private ConsoleKernelInterface $kernel;

    public function __construct(ConsoleKernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Registers all Platinum framework console commands into WP-CLI.
     */
    public function boot(): void
    {
        if (!class_exists('WP_CLI')) {
            return;
        }

        foreach ($this->kernel->commands() as $command) {
            $cliCommandName = 'platinum ' . str_replace(':', ' ', $command->name());

            WP_CLI::add_command($cliCommandName, function (array $args, array $assocArgs) use ($command): void {
                $input = new Input($args, $assocArgs);
                $output = new Output();

                $exitCode = $command->execute($input, $output);

                $text = $output->flush();
                if ($exitCode === 0) {
                    WP_CLI::success(trim($text));
                } else {
                    WP_CLI::error(trim($text));
                }
            });
        }
    }
}