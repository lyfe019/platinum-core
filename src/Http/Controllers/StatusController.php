<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Controllers;

use Platinum\Core\Persistence\Contracts\DatabaseAdapter;
use Platinum\Core\Http\Controller;
use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;

/**
 * Framework Status Controller.
 *
 * Returns the current framework health status.
 */
final class StatusController extends Controller
{
    /**
     * Create a new status controller.
     */
    public function __construct(
        private readonly DatabaseAdapter $database
    ) {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(
        Request $request
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | Database Verification
        |--------------------------------------------------------------------------
        |
        | Execute a simple query to verify that the framework can
        | communicate with the configured persistence adapter.
        |
        */

        $this->database->select('SELECT 1');

        return Response::json([
            'framework' => 'running',
            'database'  => 'connected',
            'authenticated' => $request->actor()->authenticated(),
            'actor' => $request->actor()->id(),
        ]);
    }
}