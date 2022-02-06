<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Collections\OptionSet;
use SlackPhp\BlockKit\Elements\Traits\{HasConfirm, HasInitialOption, HasOptions, HasOptionsFactory};
use SlackPhp\BlockKit\Parts\{Confirm, Option, OptionType};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Validation\{RequiresAllOf, ValidCollection};

#[RequiresAllOf('options')]
class RadioButtons extends Input
{
    use HasConfirm;
    use HasOptions;
    use HasOptionsFactory;
    use HasInitialOption;

    #[Property, ValidCollection(10)]
    public ?OptionSet $options;

    public function __construct(
        ?string $actionId = null,
        OptionSet|array|null $options = null,
        Option|null $initialOption = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $focusOnLoad);
        $this->optionType(OptionType::RADIO_GROUP);
        $this->options($options);
        $this->initialOption($initialOption);
        $this->confirm($confirm);
        $this->validator->addPreValidation($this->resolveInitialOption(...));
    }
}
