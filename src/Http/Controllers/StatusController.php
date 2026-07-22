<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Controllers;

use Platinum\Core\Http\Controller;
use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;

/**
 * Framework Status Controller.
 *
 * Returns the framework health status together with
 * the identity resolved for the current request.
 *
 * This endpoint exists primarily for framework
 * verification and should be simplified once the
 * Identity subsystem has been fully validated.
 */
final class StatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        Request $request
    ): Response {

        $actor = $request->actor();

        return Response::json([
            'framework'      => 'running',
            'authenticated'  => $actor->authenticated(),
            'actor'          => $actor->id(),
        ]);
    }
}