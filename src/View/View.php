<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Immutable View.
 *
 * Represents a renderable view within the framework.
 *
 * A View does not render itself.
 * It simply describes what should be rendered by
 * the View Engine.
 *
 * A View consists of:
 *
 * • Template
 * • ViewData
 * • ViewContext
 *
 * Rendering is delegated to the Renderer.
 */
final class View
{
    /**
     * View template.
     */
    private string $template;

    /**
     * View data.
     */
    private ViewData $data;

    /**
     * Shared rendering context.
     */
    private ViewContext $context;

    /**
     * Create a new View.
     */
    public function __construct(
        string $template,
        ?ViewData $data = null,
        ?ViewContext $context = null,
    ) {
        $this->template = $template;
        $this->data = $data ?? new ViewData();
        $this->context = $context ?? new ViewContext();
    }

    /**
     * Return the template.
     */
    public function template(): string
    {
        return $this->template;
    }

    /**
     * Return the view data.
     */
    public function data(): ViewData
    {
        return $this->data;
    }

    /**
     * Return the shared context.
     */
    public function context(): ViewContext
    {
        return $this->context;
    }

    /**
     * Determine whether the view has data.
     */
    public function hasData(): bool
    {
        return !$this->data->isEmpty();
    }

    /**
     * Determine whether the view has context.
     */
    public function hasContext(): bool
    {
        return !$this->context->isEmpty();
    }
}