<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Collections\OptionSet;
use SlackPhp\BlockKit\Elements\Traits\{HasInitialOptions, HasOptionsFactory};
use SlackPhp\BlockKit\Parts\{Confirm, OptionType, PlainText};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Validation\RequiresAllOf;

#[RequiresAllOf('placeholder')]
class MultiExternalSelectMenu extends MultiSelectMenu
{
    use HasOptionsFactory;
    use HasInitialOptions;

    #[Property('min_query_length')]
    public ?int $minQueryLength;

    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        ?int $minQueryLength = null,
        OptionSet|array|null $initialOptions = null,
        ?int $maxSelectedItems = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $placeholder, $maxSelectedItems, $confirm, $focusOnLoad);
        $this->optionType(OptionType::SELECT_MENU);
        $this->minQueryLength($minQueryLength);
        $this->initialOptions($initialOptions);
    }

    public function minQueryLength(?int $minQueryLength): self
    {
        $this->minQueryLength = $minQueryLength;

        return $this;
    }
}
