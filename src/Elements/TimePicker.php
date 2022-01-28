<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use DateTime;
use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Elements\Traits\{HasConfirm, HasPlaceholder};
use SlackPhp\BlockKit\Tools\Validator;

class TimePicker extends Input
{
    use HasConfirm;
    use HasPlaceholder;

    private const FORMAT = 'H:i';

    public ?string $initialTime;

    public function __construct(
        ?string $actionId = null,
        DateTime|string|null $initialTime = null,
        ?string $placeholder = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $focusOnLoad);
        $this->confirm($confirm);
        $this->placeholder($placeholder);
        $this->initialTime($initialTime);
    }

    public function initialTime(DateTime|string|null $initialTime): self
    {
        $this->initialTime = ($initialTime instanceof DateTime) ? $initialTime->format(self::FORMAT) : $initialTime;

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->validateDatetime('initial_time', self::FORMAT, 'HH:MM')
            ->validateSubComponents('placeholder', 'confirm');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'initial_time' => $this->initialTime,
            'placeholder' => $this->placeholder?->toArray(),
            'confirm' => $this->confirm?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->initialTime($data->useValue('initial_time'));
        $this->placeholder(PlainText::fromArray($data->useComponent('placeholder')));
        $this->confirm(Confirm::fromArray($data->useComponent('confirm')));
        parent::hydrateFromArrayData($data);
    }
}
