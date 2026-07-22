<?php

declare(strict_types=1);

namespace Platinum\Core\Integration\WordPress;

use Platinum\Core\Http\Response;
use WP_REST_Response;

/**
 * WordPress Response Adapter.
 *
 * Converts a framework response into a
 * WordPress REST response.
 */
final class WordPressResponseAdapter
{
    /**
     * Convert a framework response into a
     * WordPress REST response.
     */
    public function toWordPress(
        Response $response
    ): WP_REST_Response {
        return new WP_REST_Response(
            $response->body(),
            $response->status(),
            $response->headers(),
        );
    }
}