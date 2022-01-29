<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tools;

use SlackPhp\BlockKit\Collections\OptionGroupCollection;
use SlackPhp\BlockKit\Collections\OptionSet;
use SlackPhp\BlockKit\Enums\OptionType;
use SlackPhp\BlockKit\Parts\Option;
use SlackPhp\BlockKit\Parts\OptionGroup;

class OptionFactory
{
    public function __construct(public readonly OptionType $optionType = OptionType::SELECT_MENU)
    {
    }

    public function option(Option|string|null $option): ?Option
    {
        return Option::wrap($option)?->optionType($this->optionType);
    }

    /**
     * @param OptionSet|array<Option|string|null>|array<string, string>|null $options
     */
    public function options(OptionSet|array|null $options): OptionSet
    {
        $options = OptionSet::wrap($options);
        /** @var Option $option */
        foreach ($options as $option) {
            $option->optionType($this->optionType);
        }

        return $options;
    }

    /**
     * @param OptionGroupCollection|array<string, OptionSet|array<Option|string|null>>|array<OptionGroup>|null $optionGroups
     */
    public function optionGroups(OptionGroupCollection|array|null $optionGroups): OptionGroupCollection
    {
        $optionGroups = OptionGroupCollection::wrap($optionGroups);
        /** @var OptionGroup $optionGroup */
        foreach ($optionGroups as $optionGroup) {
            foreach ($optionGroup->options as $option) {
                $option->optionType($this->optionType);
            }
        }

        return $optionGroups;
    }
}
