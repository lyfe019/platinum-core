<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use JsonSerializable;

/**
 * Base View Model.
 *
 * A ViewModel represents the data required by a single
 * presentation use case.
 *
 * ViewModels are produced by the application layer after
 * coordinating one or more bounded contexts.
 *
 * They expose read-only data for presentation while
 * preventing the presentation layer from depending upon
 * domain models or repositories.
 *
 * ViewModels are immutable.
 */
abstract class ViewModel implements JsonSerializable
{
    /**
     * Return the view model as an array.
     *
     * Concrete implementations determine the structure
     * exposed to the presentation layer.
     *
     * @return array<string,mixed>
     */
    abstract public function toArray(): array;

    /**
     * Serialize the view model.
     *
     * @return array<string,mixed>
     */
    final public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Determine whether the model contains data.
     */
    final public function isEmpty(): bool
    {
        return empty($this->toArray());
    }

    /**
     * Determine whether the model contains data.
     */
    final public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }

    /**
     * Determine whether a property exists.
     */
    final public function has(
        string $key
    ): bool {
        return array_key_exists(
            $key,
            $this->toArray()
        );
    }

    /**
     * Return a property.
     */
    final public function get(
        string $key,
        mixed $default = null
    ): mixed {
        return $this->toArray()[$key] ?? $default;
    }
}