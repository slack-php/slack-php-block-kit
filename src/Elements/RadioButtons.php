<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Collections\OptionSet;
use SlackPhp\BlockKit\Elements\Traits\{HasConfirm, HasInitialOption, HasOptions, HasOptionsFactory};
use SlackPhp\BlockKit\Enums\OptionType;
use SlackPhp\BlockKit\Parts\{Confirm, Option};
use SlackPhp\BlockKit\Tools\{HydrationData, Validator};

class RadioButtons extends Input
{
    use HasConfirm;
    use HasOptions;
    use HasOptionsFactory;
    use HasInitialOption;

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
    }

    protected function validateInternalData(Validator $validator): void
    {
        $this->resolveInitialOption();
        $validator->requireAllOf('options')
            ->validateCollection('options', 10)
            ->validateSubComponents('initial_option', 'confirm');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'options' => $this->options?->toArray(),
            'initial_option' => $this->initialOption?->toArray(),
            'confirm' => $this->confirm?->toArray(),
            'focus_on_load' => $this->focusOnLoad,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->options(OptionSet::fromArray($data->useComponents('options')));
        $this->initialOption(Option::fromArray($data->useComponent('initial_option')));
        $this->confirm(Confirm::fromArray($data->useComponent('confirm')));
        $this->focusOnLoad($data->useValue('focus_on_load'));
        parent::hydrateFromArrayData($data);
    }
}
