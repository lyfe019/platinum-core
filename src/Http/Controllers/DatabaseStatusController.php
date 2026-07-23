<?php

declare(strict_types=1);

namespace Platinum\Core\Http\Controllers;

use Platinum\Core\Http\Controller;
use Platinum\Core\Http\Request;
use Platinum\Core\Http\Response;
use Platinum\Core\Persistence\Contracts\DatabaseAdapter;

/**
 * Database Status Controller.
 *
 * Verifies that the framework can successfully
 * communicate with the configured database.
 */
final class DatabaseStatusController extends Controller
{
    /**
     * Create a new database status controller.
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

        $result = $this->database->first(
            'SELECT 1 AS connected'
        );

        return Response::json([
            'database' => $result !== null
                ? 'connected'
                : 'disconnected',
        ]);
    }
}