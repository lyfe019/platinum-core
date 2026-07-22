<?php

declare(strict_types=1);

namespace Platinum\Core\Http;

use Platinum\Core\Http\Middleware\MiddlewarePipeline;
use Platinum\Core\Http\Middleware\MiddlewareStack;
use RuntimeException;

/**
 * Framework API Kernel.
 *
 * Entry point for every HTTP request handled by the framework.
 *
 * Responsibilities:
 * - Execute the middleware pipeline
 * - Dispatch requests to controllers
 * - Return the final HTTP response
 */
final class ApiKernel
{
    /**
     * Framework router.
     */
    private Router $router;

    /**
     * Registered middleware stack.
     */
    private MiddlewareStack $middlewareStack;

    /**
     * Middleware pipeline.
     */
    private MiddlewarePipeline $middlewarePipeline;

    /**
     * Create a new API kernel.
     */
    public function __construct(
        Router $router,
        MiddlewareStack $middlewareStack,
        MiddlewarePipeline $middlewarePipeline
    ) {
        $this->router = $router;
        $this->middlewareStack = $middlewareStack;
        $this->middlewarePipeline = $middlewarePipeline;
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

        return $this->middlewarePipeline->process(
            $request,
            $this->middlewareStack->all(),
            fn (Request $request): Response => $this->dispatch($request)
        );
    }

    /**
     * Dispatch the request to the matched controller.
     */
    private function dispatch(
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

        $controller = $this->resolveController(
            $route->action()
        );

        return $controller($request);
    }

    /**
     * Resolve the controller instance.
     */
    private function resolveController(
        string $controller
    ): callable {

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

        return $instance;
    }
}