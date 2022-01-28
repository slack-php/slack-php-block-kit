<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Elements\Traits\{HasInitialOption, HasOptionsFactory};
use SlackPhp\BlockKit\Enums\OptionType;
use SlackPhp\BlockKit\Parts\{Confirm, Option, PlainText};
use SlackPhp\BlockKit\Tools\{HydrationData, Validator};

class ExternalSelectMenu extends SelectMenu
{
    use HasOptionsFactory;
    use HasInitialOption;

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
    }

    public function minQueryLength(int $minQueryLength): self
    {
        $this->minQueryLength = $minQueryLength;

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $this->resolveInitialOption();
        $validator->validateSubComponents('initial_option');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'min_query_length' => $this->minQueryLength,
            'initial_option' => $this->initialOption?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->minQueryLength($data->useValue('min_query_length'));
        $this->initialOption(Option::fromArray($data->useComponent('initial_option')));
        parent::hydrateFromArrayData($data);
    }
}
