<?php

declare(strict_types=1);

namespace Platinum\Core\Container;

/**
 * Represents a registered service binding.
 */
final class Binding
{
    /**
     * The abstract service identifier.
     */
    public readonly string $abstract;

    /**
     * The concrete implementation.
     *
     * @var callable|string
     */
    public $concrete;

    /**
     * Indicates whether this binding is shared.
     */
    public readonly bool $shared;

    /**
     * Create a new binding.
     *
     * @param callable|string $concrete
     */
    public function __construct(
        string $abstract,
        $concrete,
        bool $shared = false
    ) {
        $this->abstract = $abstract;
        $this->concrete = $concrete;
        $this->shared = $shared;
    }
}