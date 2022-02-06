<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Collections\{OptionGroupCollection, OptionSet};
use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Elements\Traits\{HasOptionsFactory, HasOptionGroups};
use SlackPhp\BlockKit\Parts\{Option, OptionGroup, OptionType};
use SlackPhp\BlockKit\Hydration\OmitType;
use SlackPhp\BlockKit\Validation\RequiresOneOf;

/**
 * A standalone element to use for building a list of options or options group.
 *
 * This is not used in any surfaces, but it can be used to generate an app response to a block_suggestion request.
 */
#[OmitType, RequiresOneOf('options', 'option_groups')]
class OptionsResult extends Component
{
    use HasOptionsFactory;
    use HasOptionGroups;

    /**
     * @param OptionSet|array<Option|string>|array<string, string>|null $options
     * @param OptionGroupCollection|array<OptionGroup|null>|array<string, OptionSet|array<string, string>>|null $optionGroups
     */
    public function __construct(
        OptionSet|array|null $options = null,
        OptionGroupCollection|array|null $optionGroups = null,
    ) {
        parent::__construct();
        $this->optionType(OptionType::SELECT_MENU);
        $this->options($options);
        $this->optionGroups($optionGroups);
    }
}
