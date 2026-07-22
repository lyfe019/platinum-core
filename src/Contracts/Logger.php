<?php

declare(strict_types=1);

namespace Platinum\Core\Contracts;

/**
 * Logger Contract.
 *
 * Defines the logging interface used throughout the framework.
 *
 * The framework depends on this contract rather than any
 * concrete logging implementation. Different logger
 * implementations (file, database, external services, etc.)
 * can be substituted without affecting consumers.
 */
interface Logger
{
    /**
     * Record a debug message.
     *
     * @param array<string, mixed> $context
     */
    public function debug(
        string $message,
        array $context = []
    ): void;

    /**
     * Record an informational message.
     *
     * @param array<string, mixed> $context
     */
    public function info(
        string $message,
        array $context = []
    ): void;

    /**
     * Record a warning message.
     *
     * @param array<string, mixed> $context
     */
    public function warning(
        string $message,
        array $context = []
    ): void;

    /**
     * Record an error message.
     *
     * @param array<string, mixed> $context
     */
    public function error(
        string $message,
        array $context = []
    ): void;
}