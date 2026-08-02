<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use Platinum\Core\View\Contracts\RendererInterface;

/**
 * Bootstraps and wires presentation subsystem services.
 */
final class ViewServiceProvider
{
    private ViewConfig $config;

    public function __construct(ViewConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Factory method creating a fully wired ViewFacade instance.
     */
    public function boot(): ViewFacade
    {
        // 1. Path Resolution & Finding
        $viewFinder = new ViewFinder();
        foreach ($this->config->templatePaths() as $path) {
            $viewFinder->addPath($path);
        }

        $templateResolver = new TemplateResolver($viewFinder);
        $layoutResolver = new LayoutResolver($viewFinder);

        // 2. Compilation & Caching
        $cache = new TemplateCache($this->config->cachePath(), $this->config->isCacheEnabled());
        $compiler = new ViewCompiler();

        // 3. Rendering Pipeline
        $renderer = new PHPRenderer($templateResolver, $layoutResolver, $cache, $compiler);

        // 4. Asset Pipeline
        $assetResolver = new AssetResolver($this->config->assetBaseUrl());
        $assetPublisher = new AssetPublisher($assetResolver);

        // 5. Context, Slots & Partial Rendering
        $context = new PresentationContext([], $this->config->defaultLayout(), $this->config->isDebug());
        $slotManager = new SlotManager();
        $partialRenderer = new PartialRenderer($renderer);

        // 6. Facade Orchestration
        return new ViewFacade(
            $renderer,
            $context,
            $partialRenderer,
            $assetPublisher,
            $slotManager
        );
    }

    public function config(): ViewConfig
    {
        return $this->config;
    }
}