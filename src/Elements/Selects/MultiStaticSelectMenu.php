<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Collections\{OptionGroupCollection, OptionSet};
use SlackPhp\BlockKit\Elements\Traits\{HasInitialOptions, HasOptionGroups, HasOptionsFactory};
use SlackPhp\BlockKit\Parts\{Confirm, OptionType, PlainText};
use SlackPhp\BlockKit\Tools\Validation\{RequiresAllOf, RequiresOneOf};

#[RequiresAllOf('placeholder'), RequiresOneOf('options', 'option_groups')]
class MultiStaticSelectMenu extends MultiSelectMenu
{
    use HasOptionsFactory;
    use HasOptionGroups;
    use HasInitialOptions;

    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        OptionSet|array|null $options = null,
        OptionGroupCollection|array|null $optionGroups = null,
        OptionSet|array|null $initialOptions = null,
        ?int $maxSelectedItems = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $placeholder, $maxSelectedItems, $confirm, $focusOnLoad);
        $this->optionType(OptionType::SELECT_MENU);
        $this->options($options);
        $this->optionGroups($optionGroups);
        $this->initialOptions($initialOptions);
        $this->validator->addPreValidation($this->resolveInitialOptions(...));
    }
}
