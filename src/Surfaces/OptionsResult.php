<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Collections\{OptionGroupCollection, OptionSet};
use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Elements\Traits\{HasOptionsFactory, HasOptionGroups};
use SlackPhp\BlockKit\Enums\OptionType;
use SlackPhp\BlockKit\Parts\{Option, OptionGroup};
use SlackPhp\BlockKit\Tools\{HydrationData, Validator};

/**
 * A standalone element to use for building a list of options or options group.
 *
 * This is not used in any surfaces, but it can be used to generate an app response to a block_suggestion request.
 */
class OptionsResult extends Component
{
    use HasOptionsFactory;
    use HasOptionGroups;

    /**
     * @param OptionSet|array<Option|string>|array<string, string>|null $options
     * @param OptionGroupCollection|array<OptionGroup|null>|array<string, OptionSet|array<string, string>>|null $optionGroups
     */
    public function __construct(
        OptionSet|array|null $options = null,
        OptionGroupCollection|array|null $optionGroups = null,
    ) {
        parent::__construct();
        $this->optionType(OptionType::SELECT_MENU);
        $this->options($options);
        $this->optionGroups($optionGroups);
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireOneOf('options', 'option_groups')
            ->validateCollection('options', 100)
            ->validateCollection('option_groups', 100);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'options' => $this->options?->toArray(),
            'option_groups' => $this->optionGroups?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->options(OptionSet::fromArray($data->useComponents('options')));
        $this->optionGroups(OptionGroupCollection::fromArray($data->useComponents('option_groups')));
        parent::hydrateFromArrayData($data);
    }
}
