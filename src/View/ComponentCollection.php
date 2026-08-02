<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, Component>
 */
final class ComponentCollection implements IteratorAggregate, Countable
{
    /** @var Component[] */
    private array $components;

    /**
     * @param Component[] $components
     */
    public function __construct(array $components = [])
    {
        $this->components = array_values($components);
    }

    public function add(Component $component): self
    {
        $items = $this->components;
        $items[] = $component;

        return new self($items);
    }

    /**
     * Renders all components in sequence and returns the combined HTML.
     */
    public function renderAll(ComponentRenderer $renderer): string
    {
        $html = '';
        foreach ($this->components as $component) {
            $html .= $renderer->render($component);
        }

        return $html;
    }

    /**
     * @return Traversable<int, Component>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->components);
    }

    public function count(): int
    {
        return count($this->components);
    }
}