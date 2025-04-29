<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Elements\Traits\HasPlaceholder;
use SlackPhp\BlockKit\Parts\{DispatchActionConfig, PlainText};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\{RequiresAllOf, ValidString};

#[RequiresAllOf('is_decimal_allowed')]
class NumberInput extends Input
{
    use HasPlaceholder;

    #[Property('is_decimal_allowed')]
    public bool $allowDecimal;

    #[Property('initial_value'), ValidString]
    public ?string $initialValue;

    #[Property('min_value'), ValidString]
    public ?string $minValue;

    #[Property('max_value'), ValidString]
    public ?string $maxValue;

    #[Property('dispatch_action_config')]
    public ?DispatchActionConfig $dispatchActionConfig;

    public function __construct(
        ?string $actionId = null,
        ?bool $allowDecimal = null,
        int|float|string|null $maxValue = null,
        int|float|string|null $minValue = null,
        int|float|string|null $initialValue = null,
        PlainText|string|null $placeholder = null,
        ?bool $focusOnLoad = null,
        ?DispatchActionConfig $dispatchActionConfig = null,
    ) {
        parent::__construct($actionId, $focusOnLoad);
        $this->allowDecimal($allowDecimal);
        $this->maxValue($maxValue);
        $this->minValue($minValue);
        $this->initialValue($initialValue);
        $this->placeholder($placeholder);
        $this->dispatchActionConfig($dispatchActionConfig);
    }

    public function initialValue(int|float|string|null $initialValue): self
    {
        $this->initialValue = $initialValue === null ? null : (string) $initialValue;

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
