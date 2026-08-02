<?php

declare(strict_types=1);

namespace Platinum\Core\Providers;

use Platinum\Core\Container\ServiceProvider;
use Platinum\Core\View\Contracts\RendererInterface;
use Platinum\Core\View\OutputBuffer;
use Platinum\Core\View\PHPRenderer;
use Platinum\Core\View\Renderer;
use Platinum\Core\View\TemplateEngine;
use Platinum\Core\View\VariableExtractor;

/**
 * View Service Provider.
 *
 * Registers the framework View subsystem.
 */
final class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register view services.
     */
    public function register(): void
    {
        $container = $this->app->container();

        /*
        |--------------------------------------------------------------------------
        | Output Buffer
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            OutputBuffer::class,
            fn () => new OutputBuffer()
        );

        /*
        |--------------------------------------------------------------------------
        | Variable Extractor
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            VariableExtractor::class,
            fn () => new VariableExtractor()
        );

        /*
        |--------------------------------------------------------------------------
        | Template Engine
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            TemplateEngine::class,
            fn () => new TemplateEngine(
                $container->make(OutputBuffer::class),
                $container->make(VariableExtractor::class),
            )
        );

        /*
        |--------------------------------------------------------------------------
        | PHP Renderer
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            PHPRenderer::class,
            fn () => new PHPRenderer(
                $container->make(TemplateEngine::class),
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Framework Renderer
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            Renderer::class,
            fn () => new Renderer()
        );

        /*
        |--------------------------------------------------------------------------
        | Renderer Contract
        |--------------------------------------------------------------------------
        */

        $container->singleton(
            RendererInterface::class,
            fn () => $container->make(Renderer::class)
        );
    }

    /**
     * Boot view services.
     */
    public function boot(): void
    {
        //
    }
}