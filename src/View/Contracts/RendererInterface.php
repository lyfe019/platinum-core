<?php

declare(strict_types=1);

namespace Platinum\Core\View\Contracts;

use Platinum\Core\View\RenderResult;
use Platinum\Core\View\View;

/**
 * View Renderer Contract.
 *
 * Defines the contract for every renderer capable of
 * rendering a framework View.
 *
 * A renderer transforms an immutable View into an
 * immutable RenderResult.
 *
 * The renderer is presentation-framework agnostic.
 * It does not know whether the rendered result will
 * ultimately be displayed by WordPress, an API,
 * a CLI application, or another presentation layer.
 */
interface RendererInterface
{
    /**
     * Render a view.
     *
     * @throws \Platinum\Core\View\ViewException
     */
    public function render(
        View $view
    ): RenderResult;
}