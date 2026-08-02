<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use Platinum\Core\View\Contracts\RendererInterface;

final class ComponentRenderer
{
    private RendererInterface $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Renders a single UI component instance into an HTML string.
     */
    public function render(Component $component): string
    {
        $viewData = new ViewData($component->data());
        $view = new View($component->name(), null, $viewData);

        return $this->renderer->render($view)->content();
    }
}