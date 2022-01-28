<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Elements\Traits\{HasActionId, HasConfirm};
use SlackPhp\BlockKit\Enums\ButtonStyle;
use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Tools\Validator;

class Button extends Element
{
    use HasActionId;
    use HasConfirm;

    public ?PlainText $text;
    public ?string $value;
    public ?string $url;
    public ?ButtonStyle $style;

    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $text = null,
        ?string $value = null,
        ButtonStyle|string|null $style = null,
        ?string $url = null,
        ?Confirm $confirm = null,
    ) {
        parent::__construct();
        $this->actionId($actionId);
        $this->text($text);
        $this->value($value);
        $this->style($style);
        $this->url($url);
        $this->confirm($confirm);
    }

    public function text(PlainText|string|null $text): self
    {
        $this->text = PlainText::wrap($text)?->limitLength(75);

        return $this;
    }

    public function value(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function url(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function style(ButtonStyle|string|null $style): self
    {
        $this->style = ButtonStyle::fromValue($style);

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireAllOf('text')
            ->validateString('action_id', 255)
            ->validateString('url', 3000)
            ->validateString('value', 2000)
            ->validateSubComponents('text', 'confirm');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'action_id' => $this->actionId,
            'text' => $this->text?->toArray(),
            'value' => $this->value,
            'url' => $this->url,
            'style' => $this->style?->value,
            'confirm' => $this->confirm?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->actionId($data->useValue('actionId'));
        $this->text(PlainText::fromArray($data->useComponent('text')));
        $this->value($data->useValue('value'));
        $this->url($data->useValue('url'));
        $this->style($data->useValue('style'));
        $this->confirm(Confirm::fromArray($data->useComponent('confirm')));
        parent::hydrateFromArrayData($data);
    }
}
