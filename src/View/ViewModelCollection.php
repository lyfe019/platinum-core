<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Immutable collection of ViewModel instances.
 *
 * @implements IteratorAggregate<int, ViewModel>
 */
final class ViewModelCollection implements IteratorAggregate, Countable
{
    /** @var ViewModel[] */
    private array $items;

    /**
     * @param ViewModel[] $items
     */
    public function __construct(array $items = [])
    {
        $this->items = array_values($items);
    }

    /**
     * Map a array/collection of domain items using a transformer callback.
     *
     * @template T
     * @param iterable<T> $items
     * @param callable(T): ViewModel $transformer
     */
    public static function from(iterable $items, callable $transformer): self
    {
        $viewModels = [];
        foreach ($items as $item) {
            $viewModels[] = $transformer($item);
        }

        return new self($viewModels);
    }

    public function add(ViewModel $viewModel): self
    {
        $items = $this->items;
        $items[] = $viewModel;

        return new self($items);
    }

    /**
     * Transforms all ViewModels in the collection to array representations.
     *
     * @return array<int, array<string, mixed>>
     */
    public function toArray(): array
    {
        return array_map(
            static fn (ViewModel $viewModel): array => $viewModel->toArray(),
            $this->items
        );
    }

    /**
     * @return Traversable<int, ViewModel>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }
}