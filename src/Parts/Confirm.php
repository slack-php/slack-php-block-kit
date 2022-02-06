<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Elements\ButtonStyle;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Hydration\OmitType;
use SlackPhp\BlockKit\Tools\Validation\{RequiresAllOf, ValidString};

#[OmitType, RequiresAllOf('title', 'text', 'confirm', 'deny')]
class Confirm extends Component
{
    #[Property, ValidString(100)]
    public ?PlainText $title;

    #[Property, ValidString(300)]
    public ?Text $text;

    #[Property, ValidString(30)]
    public ?PlainText $confirm;

    #[Property, ValidString(30)]
    public ?PlainText $deny;

    #[Property]
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
        $this->title = PlainText::wrap($title);

        return $this;
    }

    public function text(Text|string|null $text): static
    {
        $this->text = Text::wrap($text);

        return $this;
    }

    public function confirm(PlainText|string|null $confirm): static
    {
        $this->confirm = PlainText::wrap($confirm);

        return $this;
    }

    public function deny(PlainText|string|null $deny): static
    {
        $this->deny = PlainText::wrap($deny);

        return $this;
    }

    public function style(ButtonStyle|string|null $style): static
    {
        $this->style = ButtonStyle::fromValue($style);

        return $this;
    }
}
