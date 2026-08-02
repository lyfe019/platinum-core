<?php

declare(strict_types=1);

namespace Platinum\Core\View\Contracts;

use Platinum\Core\View\ResolvedView;
use Platinum\Core\View\RenderResult;

interface PresentationRendererInterface
{
    /**
     * Renders a resolved view into a RenderResult.
     */
    public function render(ResolvedView $resolvedView): RenderResult;
}