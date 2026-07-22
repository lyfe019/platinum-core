<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Controllers;

use Platinum\Core\Http\Controller;
use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;

/**
 * Framework status controller.
 *
 * Returns the framework health status.
 */
final class StatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        Request $request
    ): Response {
        return Response::json([
            'framework' => 'running',
        ]);
    }
}