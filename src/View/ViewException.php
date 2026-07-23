<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use Exception;

/**
 * Base View Exception.
 *
 * Every exception thrown by the framework's View
 * subsystem derives from this exception.
 *
 * Concrete exceptions such as template resolution,
 * rendering, layouts, theme integration and view
 * model validation should extend this class.
 */
class ViewException extends Exception
{
}