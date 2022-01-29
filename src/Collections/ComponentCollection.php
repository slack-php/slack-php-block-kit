<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Collections;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Exception;
use Traversable;

/**
 * @template T of Component
 * @implements IteratorAggregate<T>
 * @implements ArrayAccess<int, T>
 */
abstract class ComponentCollection implements IteratorAggregate, Countable, ArrayAccess
{
    /** @var array<T> */
    protected array $components = [];

    final public static function new(): static
    {
        return new static();
    }

    final public static function wrap(self|array|null $components): static
    {
        return $components instanceof static ? $components : new static($components ?? []);
    }

    /**
     * @param array<array<string, mixed>> $data
     */
    public static function fromArray(array $data): static
    {
        $collections = static::new();
        $collections->add(array_map(fn (array $item) => static::createComponent($item), $data));

        return $collections;
    }

    /**
     * @param array<string, mixed> $data
     * @return T
     */
    abstract protected static function createComponent(array $data): Component;

    protected function add(array $components, bool $prepend = false): void
    {
        if ($prepend) {
            array_unshift($this->components, ...$this->prepareItems($components));
        } else {
            array_push($this->components, ...$this->prepareItems($components));
        }
    }

    /**
     * @param array $items
     * @return iterable<T>
     */
    abstract protected function prepareItems(array $items): iterable;

    /**
     * @param callable(T): bool $fn
     * @return array<T>
     */
    public function filter(callable $fn): array
    {
        return array_filter([...$this->components], $fn);
    }

    /**
     * @return array<array<string, mixed>>
     */
    public function toArray(): array
    {
        return array_map(fn (Component $component) => $component->toArray(), $this->components);
    }

    /**
     * @return Traversable<T>
     */
    public function getIterator(): Traversable
    {
        foreach ($this->components as $component) {
            yield $component;
        }
    }

    public function count(): int
    {
        return count($this->components);
    }

    /**
     * @param int $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->components[$offset]);
    }


    /**
     * @param int $offset
     * @return T
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->components[$offset] ?? null;
    }

    /**
     * @param int $offset
     * @param T $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset < 0 || $offset > count($this)) {
            throw new Exception('Can only modify existing or next index of %s', [static::class]);
        }

        $this->add([$value]);
    }

    /**
     * @param int $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->components[$offset]);

        $this->components = array_values($this->components);
    }
}
