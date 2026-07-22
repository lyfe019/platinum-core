<?php

declare(strict_types=1);

namespace Platinum\Core\Http;

use RuntimeException;

/**
 * Framework API Kernel.
 *
 * Entry point for every HTTP request handled by the framework.
 */
final class ApiKernel
{
    /**
     * Framework router.
     */
    private Router $router;

    /**
     * Create a new API kernel.
     */
    public function __construct(
        ?Router $router = null
    ) {
        $this->router = $router ?? new Router();
    }

    /**
     * Return the router.
     */
    public function router(): Router
    {
        return $this->router;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request
    ): Response {

        $route = $this->router->match(
            $request->method(),
            $request->uri(),
        );

        if ($route === null) {
            return Response::json(
                [
                    'message' => 'Route not found.',
                ],
                404,
            );
        }

        $controller = $route->action();

        if (! class_exists($controller)) {
            throw new RuntimeException(
                sprintf(
                    'Controller [%s] does not exist.',
                    $controller
                )
            );
        }

        $instance = new $controller();

        if (! is_callable($instance)) {
            throw new RuntimeException(
                sprintf(
                    'Controller [%s] is not invokable.',
                    $controller
                )
            );
        }

        return $instance($request);
    }
}