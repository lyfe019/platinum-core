<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Immutable Render Result.
 *
 * Represents the completed output produced by the
 * framework renderer.
 *
 * A RenderResult contains the rendered HTML together
 * with the rendering metadata that produced it.
 *
 * The result is presentation-framework agnostic.
 * It can later be consumed by a ThemeBridge,
 * API response, CLI renderer or another output
 * mechanism without modification.
 */
final class RenderResult
{
    /**
     * Rendered HTML.
     */
    private string $content;

    /**
     * Template that produced the result.
     */
    private Template $template;

    /**
     * Layout used during rendering.
     */
    private Layout $layout;

    /**
     * Rendering context.
     */
    private ViewContext $context;

    /**
     * Create a new render result.
     */
    public function __construct(
        string $content,
        Template $template,
        Layout $layout,
        ViewContext $context,
    ) {
        $this->content = $content;
        $this->template = $template;
        $this->layout = $layout;
        $this->context = $context;
    }

    /**
     * Return the rendered content.
     */
    public function content(): string
    {
        return $this->content;
    }

    /**
     * Return the template.
     */
    public function template(): Template
    {
        return $this->template;
    }

    /**
     * Return the layout.
     */
    public function layout(): Layout
    {
        return $this->layout;
    }

    /**
     * Return the rendering context.
     */
    public function context(): ViewContext
    {
        return $this->context;
    }

    /**
     * Determine whether any content was rendered.
     */
    public function isEmpty(): bool
    {
        return trim($this->content) === '';
    }

    /**
     * Determine whether content exists.
     */
    public function hasContent(): bool
    {
        return ! $this->isEmpty();
    }
}