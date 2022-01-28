<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Collections;

use SlackPhp\BlockKit\Parts\{Option, OptionGroup};
use Traversable;

/**
 * @extends ComponentCollection<OptionGroup>
 */
class OptionGroupCollection extends ComponentCollection
{
    protected static function createComponent(array $data): OptionGroup
    {
        return OptionGroup::fromArray($data);
    }

    /**
     * @param array<OptionGroup|self|null>|array<string, OptionSet|array<string, string>> $optionGroups
     */
    public function __construct(array $optionGroups = [])
    {
        if (array_is_list($optionGroups)) {
            $this->add($optionGroups);
        } else {
            $this->appendMap($optionGroups);
        }
    }

    public function append(OptionGroup|self|null ...$optionGroups): void
    {
        $this->add($optionGroups);
    }

    public function appendMap(array $optionSetMap): void
    {
        $optionGroups = [];
        foreach ($optionSetMap as $label => $optionSet) {
            $optionGroups[] = new OptionGroup((string) $label, $optionSet);
        }

        $this->add($optionGroups);
    }

    protected function prepareItems(iterable $items): iterable
    {
        foreach ($items as $optionGroup) {
            if ($optionGroup instanceof self) {
                yield from $optionGroup;
            } elseif ($optionGroup instanceof OptionGroup) {
                yield $optionGroup;
            }
        }
    }

    /**
     * @return Traversable<Option>
     */
    public function getInitial(): Traversable
    {
        foreach ($this->getIterator() as $optionGroup) {
            yield from $optionGroup->options?->getInitial();
        }
    }
}
