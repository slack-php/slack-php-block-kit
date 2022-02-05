<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Traits;

use SlackPhp\BlockKit\Collections\{OptionGroupCollection, OptionSet};
use SlackPhp\BlockKit\Parts\{Option, OptionGroup};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Validation\ValidCollection;

trait HasOptionGroups
{
    use HasOptions;

    #[Property('option_groups'), ValidCollection(100)]
    public ?OptionGroupCollection $optionGroups;

    /**
     * @param OptionGroupCollection|array<string, OptionSet|array<Option|string|null>>|array<OptionGroup>|null $optionGroups
     */
    public function optionGroups(OptionGroupCollection|array|null $optionGroups): static
    {
        $this->optionGroups = $this->optionFactory->optionGroups($optionGroups);

        return $this;
    }
}
