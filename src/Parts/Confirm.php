<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\{Component, Tools\HydrationData, Tools\Validator};
use SlackPhp\BlockKit\Enums\ButtonStyle;

class Confirm extends Component
{
    public ?PlainText $title;
    public ?Text $text;
    public ?PlainText $confirm;
    public ?PlainText $deny;
    public ?ButtonStyle $style;

    public function __construct(
        PlainText|string|null $title = null,
        Text|string|null $text = null,
        PlainText|string|null $confirm = 'OK',
        PlainText|string|null $deny = 'Cancel',
        ButtonStyle|string|null $style = null,
    ) {
        parent::__construct();
        $this->title($title);
        $this->text($text);
        $this->confirm($confirm);
        $this->deny($deny);
        $this->style($style);
    }

    public function title(PlainText|string|null $title): static
    {
        $this->title = PlainText::wrap($title)?->limitLength(100);

        return $this;
    }

    public function text(Text|string|null $text): static
    {
        $this->text = Text::wrap($text)?->limitLength(300);

        return $this;
    }

    public function confirm(PlainText|string|null $confirm): static
    {
        $this->confirm = PlainText::wrap($confirm)?->limitLength(30);

        return $this;
    }

    public function deny(PlainText|string|null $deny): static
    {
        $this->deny = PlainText::wrap($deny)?->limitLength(30);

        return $this;
    }

    public function style(ButtonStyle|string|null $style): static
    {
        $this->style = ButtonStyle::fromValue($style);

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireAllOf('title', 'text', 'confirm', 'deny')
            ->validateSubComponents('title', 'text', 'confirm', 'deny');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'title' => $this->title?->toArray(),
            'text' => $this->text?->toArray(),
            'confirm' => $this->confirm?->toArray(),
            'deny' => $this->deny?->toArray(),
            'style' => $this->style?->value,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->title(PlainText::fromArray($data->useComponent('title')));
        $this->text(Text::fromArray($data->useComponent('text')));
        $this->confirm(PlainText::fromArray($data->useComponent('confirm')));
        $this->deny(PlainText::fromArray($data->useComponent('deny')));
        $this->style($data->useValue('style'));
        parent::hydrateFromArrayData($data);
    }
}
