<?php

declare(strict_types=1);

namespace Platinum\Core\Persistence\Exceptions;

use RuntimeException;

/**
 * Database Exception.
 *
 * Represents a persistence error occurring while
 * interacting with the underlying data store.
 *
 * Framework components depend on this exception
 * rather than host-specific database exceptions.
 */
final class DatabaseException extends RuntimeException
{
}