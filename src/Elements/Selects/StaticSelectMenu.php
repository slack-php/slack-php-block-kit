<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Collections\{OptionGroupCollection, OptionSet};
use SlackPhp\BlockKit\Elements\Traits\{HasInitialOption, HasOptionsFactory, HasOptionGroups};
use SlackPhp\BlockKit\Enums\OptionType;
use SlackPhp\BlockKit\Parts\{Confirm, Option, PlainText};
use SlackPhp\BlockKit\Tools\{HydrationData, Validator};

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
    }

    protected function validateInternalData(Validator $validator): void
    {
        $this->resolveInitialOption();
        $validator->requireOneOf('options', 'option_groups')
            ->validateCollection('options', 100)
            ->validateCollection('option_groups', 100)
            ->validateSubComponents('initial_option');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'options' => $this->options?->toArray(),
            'option_groups' => $this->optionGroups?->toArray(),
            'initial_option' => $this->initialOption?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->options(OptionSet::fromArray($data->useComponents('options')));
        $this->optionGroups(OptionGroupCollection::fromArray($data->useComponents('option_groups')));
        $this->initialOption(Option::fromArray($data->useComponent('initial_option')));
        parent::hydrateFromArrayData($data);
    }
}
