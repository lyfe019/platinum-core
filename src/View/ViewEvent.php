<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Immutable View Event emitted during the rendering lifecycle.
 */
final class ViewEvent
{
    public const BEFORE_RENDER = 'view.before_render';
    public const AFTER_RENDER = 'view.after_render';
    public const RENDER_ERROR = 'view.render_error';

    private string $name;
    private View $view;
    private ?RenderResult $result;
    /** @var array<string, mixed> */
    private array $metadata;

    /**
     * @param array<string, mixed> $metadata
     */
    public function __construct(
        string $name,
        View $view,
        ?RenderResult $result = null,
        array $metadata = []
    ) {
        $this->name = $name;
        $this->view = $view;
        $this->result = $result;
        $this->metadata = $metadata;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function view(): View
    {
        return $this->view;
    }

    public function result(): ?RenderResult
    {
        return $this->result;
    }

    /**
     * @return array<string, mixed>
     */
    public function metadata(): array
    {
        return $this->metadata;
    }
}