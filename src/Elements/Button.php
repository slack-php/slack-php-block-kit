<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Elements\Traits\{HasActionId, HasConfirm};
use SlackPhp\BlockKit\Parts\{Confirm, PlainText};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Validation\{RequiresAllOf, ValidString};

#[RequiresAllOf('text')]
class Button extends Element
{
    use HasActionId;
    use HasConfirm;

    #[Property, ValidString(75)]
    public ?PlainText $text;

    #[Property, ValidString(2000)]
    public ?string $value;

    #[Property, ValidString(3000)]
    public ?string $url;

    #[Property]
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
        $this->text = PlainText::wrap($text);

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
}
