<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Collections\{OptionGroupCollection, OptionSet};
use SlackPhp\BlockKit\Elements\Traits\{HasInitialOptions, HasOptionGroups, HasOptionsFactory};
use SlackPhp\BlockKit\Enums\OptionType;
use SlackPhp\BlockKit\Parts\{Confirm, PlainText};
use SlackPhp\BlockKit\Tools\{HydrationData, Validator};

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
    }

    protected function validateInternalData(Validator $validator): void
    {
        $this->resolveInitialOptions();
        $validator->requireOneOf('options', 'option_groups')
            ->validateCollection('options', 100)
            ->validateCollection('option_groups', 100)
            ->validateCollection('initial_options', $this->maxSelectedItems ?? 0);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'options' => $this->options?->toArray(),
            'option_groups' => $this->optionGroups?->toArray(),
            'initial_options' => $this->initialOptions?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->options(OptionSet::fromArray($data->useComponents('options')));
        $this->optionGroups(OptionGroupCollection::fromArray($data->useComponents('option_groups')));
        $this->initialOptions(OptionSet::fromArray($data->useComponents('initial_options')));
        parent::hydrateFromArrayData($data);
    }
}
