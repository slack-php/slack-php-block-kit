<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Collections\{OptionGroupCollection, OptionSet};
use SlackPhp\BlockKit\Elements\Traits\{HasInitialOption, HasOptionsFactory, HasOptionGroups};
use SlackPhp\BlockKit\Parts\{Confirm, Option, OptionType, PlainText};
use SlackPhp\BlockKit\Validation\{RequiresAllOf, RequiresOneOf};

#[RequiresAllOf('placeholder'), RequiresOneOf('options', 'option_groups')]
class StaticSelectMenu extends SelectMenu
{
    use HasOptionsFactory;
    use HasOptionGroups;
    use HasInitialOption;

    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        OptionSet|array|null $options = null,
        OptionGroupCollection|array|null $optionGroups = null,
        Option|string|null $initialOption = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $placeholder, $confirm, $focusOnLoad);
        $this->optionType(OptionType::SELECT_MENU);
        $this->options($options);
        $this->optionGroups($optionGroups);
        $this->initialOption($initialOption);
        $this->validator->addPreValidation($this->resolveInitialOption(...));
    }
}
