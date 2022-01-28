<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use DateTime;
use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Elements\Traits\{HasConfirm, HasPlaceholder};
use SlackPhp\BlockKit\Tools\Validator;

class DatePicker extends Input
{
    use HasConfirm;
    use HasPlaceholder;

    private const FORMAT = 'Y-m-d';

    public ?string $initialDate;

    public function __construct(
        ?string $actionId = null,
        DateTime|string|null $initialDate = null,
        ?string $placeholder = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $focusOnLoad);
        $this->confirm($confirm);
        $this->placeholder($placeholder);
        $this->initialDate($initialDate);
    }

    public function initialDate(DateTime|string|null $initialDate): self
    {
        $this->initialDate = ($initialDate instanceof DateTime) ? $initialDate->format(self::FORMAT) : $initialDate;

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->validateDatetime('initial_date', self::FORMAT, 'YYYY-MM-DD')
            ->validateSubComponents('placeholder', 'confirm');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'initial_date' => $this->initialDate,
            'placeholder' => $this->placeholder?->toArray(),
            'confirm' => $this->confirm?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->initialDate($data->useValue('initial_date'));
        $this->placeholder(PlainText::fromArray($data->useComponent('placeholder')));
        $this->confirm(Confirm::fromArray($data->useComponent('confirm')));
        parent::hydrateFromArrayData($data);
    }
}
