<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Collections\OptionSet;
use SlackPhp\BlockKit\Elements\Traits\{HasConfirm, HasInitialOptions, HasOptions, HasOptionsFactory};
use SlackPhp\BlockKit\Parts\{Confirm, OptionType};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\{RequiresAllOf, ValidCollection};

#[RequiresAllOf('options')]
class Checkboxes extends Input
{
    use HasOptionsFactory;
    use HasConfirm;
    use HasOptions;
    use HasInitialOptions;

    #[Property, ValidCollection(10)]
    public ?OptionSet $options;

    public function __construct(
        ?string $actionId = null,
        OptionSet|array|null $options = null,
        OptionSet|array|null $initialOptions = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $focusOnLoad);
        $this->optionType(OptionType::CHECKBOX_GROUP);
        $this->options($options);
        $this->initialOptions($initialOptions);
        $this->confirm($confirm);
        $this->validator->addPreValidation($this->resolveInitialOptions(...));
    }
}
