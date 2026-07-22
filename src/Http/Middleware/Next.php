<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Middleware;

use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;

/**
 * Middleware Pipeline Continuation Contract.
 *
 * Represents the next executable step within the
 * middleware pipeline.
 *
 * Implementations determine whether execution continues
 * to another middleware or finally reaches the controller.
 */
interface Next
{
    /**
     * Continue execution through the pipeline.
     */
    public function handle(
        Request $request
    ): Response;
}