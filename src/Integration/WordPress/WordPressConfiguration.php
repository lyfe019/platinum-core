<?php

declare(strict_types=1);

namespace Platinum\Core\Integration\WordPress;

/**
 * WordPress integration configuration.
 *
 * Provides constants shared by the WordPress
 * integration layer.
 */
final class WordPressConfiguration
{
    /**
     * REST API namespace.
     */
    public const REST_NAMESPACE = 'platinum/v1';

    /**
     * Prevent instantiation.
     */
    private function __construct()
    {
    }
}