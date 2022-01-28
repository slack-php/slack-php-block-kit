<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Traits;

use SlackPhp\BlockKit\Collections\{OptionGroupCollection, OptionSet};
use SlackPhp\BlockKit\Parts\OptionGroup;

trait HasOptionGroups
{
    use HasOptions;

    public ?OptionGroupCollection $optionGroups = null;

    /**
     * @param OptionGroupCollection|array<string, OptionSet|array>|array<OptionGroup>|null $optionGroups
     */
    public function optionGroups(OptionGroupCollection|array|null $optionGroups): static
    {
        $this->optionGroups = $this->optionFactory->optionGroups($optionGroups);

        return $this;
    }
}
