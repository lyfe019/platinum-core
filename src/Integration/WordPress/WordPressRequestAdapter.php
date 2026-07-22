<?php

declare(strict_types=1);

namespace Platinum\Core\Integration\WordPress;

use Platinum\Core\Http\Request;
use WP_REST_Request;

/**
 * WordPress Request Adapter.
 *
 * Converts a WordPress REST request into the
 * framework's HTTP request object.
 */
final class WordPressRequestAdapter
{
    /**
     * Convert a WordPress request into a framework request.
     */
    public function fromWordPress(
        WP_REST_Request $request
    ): Request {
        return new Request(
            method: $request->get_method(),
            uri: $this->normalizeUri(
                $request->get_route()
            ),
            query: $request->get_query_params(),
            body: $this->resolveBody($request),
            headers: $request->get_headers(),
            ip: $this->resolveIp(),
        );
    }

    /**
     * Normalize a WordPress REST route into
     * a framework route.
     */
    private function normalizeUri(
        string $route
    ): string {

        $namespace = '/'
            . WordPressConfiguration::REST_NAMESPACE;

        if (str_starts_with($route, $namespace)) {
            $route = substr(
                $route,
                strlen($namespace)
            );
        }

        if ($route === '') {
            return '/';
        }

        return $route;
    }

    /**
     * Resolve the request body.
     *
     * JSON requests use decoded JSON. All other
     * requests fall back to standard body parameters.
     *
     * @return array<string, mixed>
     */
    private function resolveBody(
        WP_REST_Request $request
    ): array {

        $json = $request->get_json_params();

        if (! empty($json)) {
            return $json;
        }

        return $request->get_body_params();
    }

    /**
     * Resolve the client IP address.
     *
     * For now, the framework uses the direct remote
     * address reported by the web server. Support for
     * trusted proxy headers (such as X-Forwarded-For)
     * can be introduced later without changing the
     * Request abstraction.
     */
    private function resolveIp(): string
    {
        return $_SERVER['REMOTE_ADDR']
            ?? '0.0.0.0';
    }
}