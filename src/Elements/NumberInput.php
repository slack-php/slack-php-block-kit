<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Elements\Traits\HasPlaceholder;
use SlackPhp\BlockKit\Parts\{DispatchActionConfig, PlainText};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\ValidInt;
use SlackPhp\BlockKit\Validation\{RequiresAllOf, ValidString};

#[RequiresAllOf('is_decimal_allowed')]
class NumberInput extends Input
{
    use HasPlaceholder;

    #[Property('is_decimal_allowed')]
    public bool $decimalAllowed = false;

    #[Property('initial_value')]
    public ?string $initialValue;

    #[Property('min_value')]
    public ?int $minValue;

    #[Property('max_value')]
    public ?int $maxValue;

    #[Property('dispatch_action_config')]
    public ?DispatchActionConfig $dispatchActionConfig;

    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        ?int $maxValue = null,
        ?int $minValue = null,
        ?DispatchActionConfig $dispatchActionConfig = null,
        ?string $initialValue = null,
        bool $decimalAllowed = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $focusOnLoad);
        $this->placeholder($placeholder);
        $this->maxValue($maxValue);
        $this->minValue($minValue);
        $this->dispatchActionConfig($dispatchActionConfig);
        $this->initialValue($initialValue);
        $this->decimalAllowed($decimalAllowed);
    }

    public function initialValue(?string $text): self
    {
        $this->initialValue = $text;

        return $this;
    }

    public function minValue(int|float|string|null $minValue): self
    {
        $this->minValue = $minValue === null ? null : (string) $minValue;

        return $this;
    }

    public function maxValue(int|float|string|null $maxValue): self
    {
        $this->maxValue = $maxValue === null ? null : (string) $maxValue;

        return $this;
    }

    public function dispatchActionConfig(?DispatchActionConfig $config): self
    {
        $this->dispatchActionConfig = $config;

        return $this;
    }

    public function allowDecimal(?bool $allowDecimal): self
    {
        $this->allowDecimal = (bool) $allowDecimal;

        return $this;
    }
}
