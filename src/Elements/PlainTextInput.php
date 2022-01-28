<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Parts\{DispatchActionConfig, PlainText};
use SlackPhp\BlockKit\Elements\Traits\HasPlaceholder;
use SlackPhp\BlockKit\Tools\Validator;

class PlainTextInput extends Input
{
    use HasPlaceholder;

    public ?string $initialValue;
    public ?bool $multiline;
    public ?int $minLength;
    public ?int $maxLength;
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
        $this->maxLength = $maxLength === null ? null : (int) min(1, $maxLength);

        return $this;
    }

    public function dispatchActionConfig(?DispatchActionConfig $config): self
    {
        $this->dispatchActionConfig = $config;

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->validateInt('min_length', 3000)
            ->validateInt('max_length', 0, $this->minLength ?? 0)
            ->validateSubComponents('placeholder', 'dispatch_action_config');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'placeholder' => $this->placeholder?->toArray(),
            'initial_value' => $this->initialValue,
            'multiline' => $this->multiline,
            'min_length' => $this->minLength,
            'max_length' => $this->maxLength,
            'dispatch_action_config' => $this->dispatchActionConfig,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->initialValue($data->useValue('initial_value'));
        $this->multiline($data->useValue('multiline'));
        $this->minLength($data->useValue('min_length'));
        $this->maxLength($data->useValue('max_length'));
        $this->placeholder(PlainText::fromArray($data->useComponent('placeholder')));
        $this->dispatchActionConfig(DispatchActionConfig::fromArray($data->useComponent('dispatch_action_config')));
        parent::hydrateFromArrayData($data);
    }
}
