<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Elements\Traits\HasPlaceholder;
use SlackPhp\BlockKit\Parts\{DispatchActionConfig, PlainText};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\ValidInt;

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

    public function minValue(?int $value): self
    {
        $this->minValue = $value;

        return $this;
    }

    public function maxValue(?int $value): self
    {
        $this->maxValue = $value;

        return $this;
    }

    public function dispatchActionConfig(?DispatchActionConfig $config): self
    {
        $this->dispatchActionConfig = $config;

        return $this;
    }

    public function decimalAllowed(?bool $allowedDecimal): self
    {
        $this->decimalAllowed = (bool) $allowedDecimal;

        return $this;
    }
}
