<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use Platinum\Core\View\Contracts\RendererInterface;

/**
 * Handles rendering of scoped, partial template views.
 */
final class PartialRenderer
{
    private RendererInterface $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Render a sub-view template with isolated variables.
     *
     * @param array<string, mixed> $data
     */
    public function renderPartial(string $partialPath, array $data = []): string
    {
        $viewData = new ViewData($data);
        $view = new View($partialPath, null, $viewData);

        return $this->renderer->render($view)->content();
    }

    /**
     * Batch render a partial template across a collection of items.
     *
     * @param iterable<mixed> $items
     * @param string $itemKey Variable name exposed inside the partial view for each item.
     * @param array<string, mixed> $additionalData
     */
    public function renderLoop(string $partialPath, iterable $items, string $itemKey = 'item', array $additionalData = []): string
    {
        $output = '';
        foreach ($items as $item) {
            $scope = array_merge($additionalData, [$itemKey => $item]);
            $output .= $this->renderPartial($partialPath, $scope);
        }

        return $output;
    }
}