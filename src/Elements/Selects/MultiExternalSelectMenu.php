<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Collections\OptionSet;
use SlackPhp\BlockKit\Elements\Traits\{HasInitialOptions, HasOptionsFactory};
use SlackPhp\BlockKit\Enums\OptionType;
use SlackPhp\BlockKit\Parts\{Confirm, PlainText};
use SlackPhp\BlockKit\Tools\{HydrationData, Validator};

class MultiExternalSelectMenu extends MultiSelectMenu
{
    use HasOptionsFactory;
    use HasInitialOptions;

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

    protected function validateInternalData(Validator $validator): void
    {
        $this->resolveInitialOptions();
        $validator->validateCollection('initial_options', $this->maxSelectedItems ?? 0);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'min_query_length' => $this->minQueryLength,
            'initial_options' => $this->initialOptions?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->initialOptions(OptionSet::fromArray($data->useComponents('initial_options')));
        $this->minQueryLength($data->useValue('min_query_length'));
        parent::hydrateFromArrayData($data);
    }
}
