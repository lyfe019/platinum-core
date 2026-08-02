<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use Platinum\Core\View\Contracts\PresentationRendererInterface;

final class PHPRenderer implements PresentationRendererInterface
{
    private TemplateEngine $engine;

    public function __construct(?TemplateEngine $engine = null)
    {
        $this->engine = $engine ?? new TemplateEngine();
    }

    public function render(ResolvedView $resolvedView): RenderResult
    {
        // 1. Render the main template file
        $content = $this->engine->renderFile(
            $resolvedView->templateLocation()->path(),
            $resolvedView->data(),
            $resolvedView->context()
        );

        // 2. If a layout is present, render the layout with $content passed into ViewData
        if ($resolvedView->hasLayout()) {
            $layoutData = $resolvedView->data()->with('content', $content);

            $content = $this->engine->renderFile(
                $resolvedView->layoutLocation()->path(),
                $layoutData,
                $resolvedView->context()
            );
        }

        return new RenderResult(
            $content,
            $resolvedView->context(),
            [
                'template' => $resolvedView->templateLocation()->path(),
                'layout' => $resolvedView->hasLayout() ? $resolvedView->layoutLocation()->path() : null,
                'engine' => 'php',
            ]
        );
    }
}