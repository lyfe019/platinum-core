<?php

declare(strict_types=1);

namespace Platinum\Core\Logging;

use Platinum\Core\Contracts\Logger;

/**
 * Default Framework Logger.
 *
 * Provides the framework's default logging implementation.
 *
 * This implementation writes log entries using PHP's
 * native error_log() function. It serves as the default
 * logger until a more advanced structured logging system
 * is introduced in Phase 16.
 */
final class DefaultLogger implements Logger
{
    /**
     * Record a debug message.
     *
     * @param array<string, mixed> $context
     */
    public function debug(
        string $message,
        array $context = []
    ): void {
        $this->write(
            'DEBUG',
            $message,
            $context
        );
    }

    /**
     * Record an informational message.
     *
     * @param array<string, mixed> $context
     */
    public function info(
        string $message,
        array $context = []
    ): void {
        $this->write(
            'INFO',
            $message,
            $context
        );
    }

    /**
     * Record a warning message.
     *
     * @param array<string, mixed> $context
     */
    public function warning(
        string $message,
        array $context = []
    ): void {
        $this->write(
            'WARNING',
            $message,
            $context
        );
    }

    /**
     * Record an error message.
     *
     * @param array<string, mixed> $context
     */
    public function error(
        string $message,
        array $context = []
    ): void {
        $this->write(
            'ERROR',
            $message,
            $context
        );
    }

    /**
     * Write a log entry.
     *
     * @param array<string, mixed> $context
     */
    private function write(
        string $level,
        string $message,
        array $context
    ): void {
        error_log(
            sprintf(
                '[%s] %s %s',
                $level,
                $message,
                empty($context)
                    ? ''
                    : json_encode(
                        $context,
                        JSON_UNESCAPED_SLASHES
                        | JSON_UNESCAPED_UNICODE
                    )
            )
        );
    }
}