<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Elements\Traits\HasActionId;
use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Tools\Validator;

abstract class Input extends Element
{
    use HasActionId;

    public ?bool $focusOnLoad;

    public function __construct(?string $actionId = null, ?bool $focusOnLoad = null)
    {
        parent::__construct();
        $this->actionId($actionId);
        $this->focusOnLoad($focusOnLoad);
    }

    public function focusOnLoad(?bool $focusOnLoad): static
    {
        $this->focusOnLoad = $focusOnLoad;

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->validateString('action_id', 255);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'action_id' => $this->actionId,
            'focus_on_load' => $this->focusOnLoad,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->actionId($data->useValue('action_id'));
        $this->focusOnLoad($data->useValue('focus_on_load'));
        parent::hydrateFromArrayData($data);
    }
}
