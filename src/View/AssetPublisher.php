<?php

declare(strict_types=1);

namespace Platinum\Core\View;

final class AssetPublisher
{
    private AssetResolver $resolver;
    /** @var array<string, Style> */
    private array $styles = [];
    /** @var array<string, Script> */
    private array $scripts = [];

    public function __construct(?AssetResolver $resolver = null)
    {
        $this->resolver = $resolver ?? new AssetResolver();
    }

    public function registerStyle(Style $style): void
    {
        $resolvedStyle = new Style(
            $style->handle(),
            $this->resolver->resolve($style->src()),
            $style->dependencies(),
            $style->version(),
            $style->media()
        );

        $this->styles[$style->handle()] = $resolvedStyle;
    }

    public function registerScript(Script $script): void
    {
        $resolvedScript = new Script(
            $script->handle(),
            $this->resolver->resolve($script->src()),
            $script->dependencies(),
            $script->version(),
            $script->inFooter(),
            $script->isDefer(),
            $script->isAsync(),
            $script->isModule()
        );

        $this->scripts[$script->handle()] = $resolvedScript;
    }

    /**
     * @return Style[]
     */
    public function styles(): array
    {
        return array_values($this->styles);
    }

    /**
     * @return Script[]
     */
    public function scripts(): array
    {
        return array_values($this->scripts);
    }
}