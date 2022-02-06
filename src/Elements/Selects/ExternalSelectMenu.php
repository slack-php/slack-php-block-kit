<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Elements\Traits\{HasInitialOption, HasOptionsFactory};
use SlackPhp\BlockKit\Parts\{Confirm, Option, OptionType, PlainText};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;

#[RequiresAllOf('placeholder')]
class ExternalSelectMenu extends SelectMenu
{
    use HasOptionsFactory;
    use HasInitialOption;

    #[Property('min_query_length')]
    public ?int $minQueryLength;

    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        ?int $minQueryLength = null,
        Option|string|null $initialOption = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $placeholder, $confirm, $focusOnLoad);
        $this->optionType(OptionType::SELECT_MENU);
        $this->minQueryLength($minQueryLength);
        $this->initialOption($initialOption);
        $this->validator->addPreValidation($this->resolveInitialOption(...));
    }

    public function minQueryLength(?int $minQueryLength): self
    {
        $this->minQueryLength = $minQueryLength;

        return $this;
    }
}
