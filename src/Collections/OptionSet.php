<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Collections;

use SlackPhp\BlockKit\Parts\Option;
use Traversable;

/**
 * @extends ComponentCollection<Option>
 */
class OptionSet extends ComponentCollection
{
    /** @var array<string, bool> */
    private array $stored;

    protected static function createComponent(array $data): Option
    {
        return Option::fromArray($data);
    }

    /**
     * @param array<Option|self|string|null>|array<string, string> $options
     */
    public function __construct(array $options = [])
    {
        if (array_is_list($options)) {
            $this->add($options);
        } else {
            $this->appendMap($options);
        }
    }

    public function append(Option|self|string|null ...$options): void
    {
        $this->add($options);
    }

    public function appendMap(array $optionsMap): void
    {
        $options = [];
        foreach ($optionsMap as $text => $value) {
            $options[] = new Option((string) $text, (string) $value);
        }

        $this->add($options);
    }

    protected function prepareItems(iterable $items): iterable
    {
        foreach ($items as $option) {
            if (is_iterable($option)) {
                yield from $option;
                continue;
            }

            $option = Option::wrap($option);
            if ($option === null) {
                continue;
            }

            $hash = $option->hash();
            if (isset($this->stored[$hash])) {
                continue;
            }

            $this->stored[$hash] = true;

            yield $option;
        }
    }

    /**
     * @return Traversable<Option>
     */
    public function getInitial(): Traversable
    {
        foreach ($this->getIterator() as $option) {
            if ($option->initial) {
                yield $option;
            }
        }
    }
}
