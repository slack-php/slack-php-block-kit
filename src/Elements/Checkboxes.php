<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Collections\OptionSet;
use SlackPhp\BlockKit\Elements\Traits\{HasConfirm, HasInitialOptions, HasOptions, HasOptionsFactory};
use SlackPhp\BlockKit\Enums\OptionType;
use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Tools\{HydrationData, Validator};

class Checkboxes extends Input
{
    use HasOptionsFactory;
    use HasConfirm;
    use HasOptions;
    use HasInitialOptions;

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
    }

    protected function validateInternalData(Validator $validator): void
    {
        $this->resolveInitialOptions();
        $validator->requireAllOf('options')
            ->validateCollection('options', 10)
            ->validateCollection('initial_options', 10)
            ->validateSubComponents('confirm');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'options' => $this->options?->toArray(),
            'initial_options' => $this->initialOptions?->toArray(),
            'confirm' => $this->confirm?->toArray(),
            'focus_on_load' => $this->focusOnLoad,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->options(OptionSet::fromArray($data->useComponents('options')));
        $this->initialOptions(OptionSet::fromArray($data->useComponents('initial_options')));
        $this->confirm(Confirm::fromArray($data->useComponent('confirm')));
        $this->focusOnLoad($data->useValue('focus_on_load'));
        parent::hydrateFromArrayData($data);
    }
}
