<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Collections\OptionSet;
use SlackPhp\BlockKit\Elements\Traits\{HasActionId, HasConfirm, HasOptions, HasOptionsFactory};
use SlackPhp\BlockKit\Enums\OptionType;
use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Tools\{HydrationData, Validator};

class OverflowMenu extends Element
{
    use HasActionId;
    use HasConfirm;
    use HasOptionsFactory;
    use HasOptions;

    public function __construct(
        ?string $actionId = null,
        OptionSet|array|null $options = null,
        ?Confirm $confirm = null,
    ) {
        parent::__construct();
        $this->actionId($actionId);
        $this->optionType(OptionType::OVERFLOW_MENU);
        $this->options($options);
        $this->confirm($confirm);
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireAllOf('options')
            ->validateCollection('options', 5, 2)
            ->validateString('action_id', 255)
            ->validateSubComponents('confirm');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'options' => $this->options?->toArray(),
            'confirm' => $this->confirm?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->options(OptionSet::fromArray($data->useComponents('options')));
        $this->confirm(Confirm::fromArray($data->useComponent('confirm')));
        parent::hydrateFromArrayData($data);
    }
}
