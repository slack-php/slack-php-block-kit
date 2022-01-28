<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Elements\Input;
use SlackPhp\BlockKit\Elements\Traits\{HasConfirm, HasPlaceholder};
use SlackPhp\BlockKit\Parts\{Confirm, PlainText};
use SlackPhp\BlockKit\Tools\{HydrationData, Validator};

abstract class Menu extends Input
{
    use HasConfirm;
    use HasPlaceholder;

    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $focusOnLoad);
        $this->placeholder($placeholder);
        $this->confirm($confirm);
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireAllOf('placeholder')
            ->validateSubComponents('placeholder', 'confirm');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'placeholder' => $this->placeholder?->toArray(),
            'confirm' => $this->confirm?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->placeholder(PlainText::fromArray($data->useComponent('placeholder')));
        $this->confirm(Confirm::fromArray($data->useComponent('confirm')));
        parent::hydrateFromArrayData($data);
    }
}
