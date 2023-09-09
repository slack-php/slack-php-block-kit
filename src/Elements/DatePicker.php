<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use DateTimeInterface;
use SlackPhp\BlockKit\Elements\Traits\{HasConfirm, HasPlaceholder};
use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\ValidDatetime;

class DatePicker extends Input
{
    use HasConfirm;
    use HasPlaceholder;

    #[Property('initial_date'), ValidDatetime('Y-m-d', 'YYYY-MM-DD')]
    public ?string $initialDate;

    public function __construct(
        ?string $actionId = null,
        DateTimeInterface|string|null $initialDate = null,
        ?string $placeholder = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $focusOnLoad);
        $this->confirm($confirm);
        $this->placeholder($placeholder);
        $this->initialDate($initialDate);
    }

    public function initialDate(DateTimeInterface|string|null $initialDate): self
    {
        $this->initialDate = ($initialDate instanceof DateTimeInterface) ? $initialDate->format('Y-m-d') : $initialDate;

        return $this;
    }
}
