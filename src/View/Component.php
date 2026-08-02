<?php

declare(strict_types=1);

namespace Platinum\Core\View;

abstract class Component
{
    /** @var array<string, mixed> */
    protected array $props;
    protected ?string $slot;

    /**
     * @param array<string, mixed> $props
     */
    public function __construct(array $props = [], ?string $slot = null)
    {
        $this->props = $props;
        $this->slot = $slot;
    }

    /**
     * Logical view path to the component template (e.g., 'components.button').
     */
    abstract public function name(): string;

    /**
     * Returns the array of data/props passed into the component template scope.
     *
     * @return array<string, mixed>
     */
    public function data(): array
    {
        return array_merge($this->props, [
            'slot' => $this->slot,
        ]);
    }
}