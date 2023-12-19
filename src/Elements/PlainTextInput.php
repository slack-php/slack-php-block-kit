<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Elements\Traits\HasPlaceholder;
use SlackPhp\BlockKit\Parts\{DispatchActionConfig, PlainText};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\ValidInt;

class PlainTextInput extends Input
{
    use HasPlaceholder;

    #[Property('initial_value')]
    public ?string $initialValue;

    #[Property('min_length'), ValidInt(3000)]
    public ?int $minLength;

    #[Property('max_length')]
    public ?int $maxLength;

    #[Property]
    public ?bool $multiline;

    #[Property('dispatch_action_config')]
    public ?DispatchActionConfig $dispatchActionConfig;

    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        ?int $maxLength = null,
        ?int $minLength = null,
        ?bool $multiline = null,
        ?DispatchActionConfig $dispatchActionConfig = null,
        ?string $initialValue = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $focusOnLoad);
        $this->placeholder($placeholder);
        $this->maxLength($maxLength);
        $this->minLength($minLength);
        $this->multiline($multiline);
        $this->dispatchActionConfig($dispatchActionConfig);
        $this->initialValue($initialValue);
    }

    public function initialValue(?string $text): self
    {
        $this->initialValue = $text;

        return $this;
    }

    public function multiline(?bool $flag): self
    {
        $this->multiline = $flag;

        return $this;
    }

    public function minLength(?int $minLength): self
    {
        $this->minLength = $minLength === null ? null : (int) max(0, $minLength);

        return $this;
    }

    public function maxLength(?int $maxLength): self
    {
        $this->maxLength = $maxLength === null ? null : (int) max(1, $maxLength);

        return $this;
    }

    public function dispatchActionConfig(?DispatchActionConfig $config): self
    {
        $this->dispatchActionConfig = $config;

        return $this;
    }
}
