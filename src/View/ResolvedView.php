<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Resolved View.
 *
 * Represents a fully resolved framework view.
 *
 * A resolved view is produced by the ViewFinder after
 * translating a logical View into its concrete rendering
 * components.
 *
 * It contains the resolved template and layout required
 * by the rendering pipeline.
 *
 * The object is immutable.
 */
final class ResolvedView
{
    /**
     * Create a new resolved view.
     */
    public function __construct(
        private Template $template,
        private Layout $layout,
    ) {
    }

    /**
     * Return the resolved template.
     */
    public function template(): Template
    {
        return $this->template;
    }

    /**
     * Return the resolved layout.
     */
    public function layout(): Layout
    {
        return $this->layout;
    }
}