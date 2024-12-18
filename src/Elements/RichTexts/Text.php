<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Parts\Style;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;

#[RequiresAllOf('text')]
class Text extends RichTextElement
{
    #[Property]
    public ?string $text;

    #[Property]
    public ?Style $style;

    public static function wrap(string|self|null $text): ?self
    {
        return is_string($text) ? new self($text) : $text;
    }

    public function __construct(?string $text = null, ?Style $style = null)
    {
        parent::__construct();
        $this->text($text);
        $this->style($style);
    }

    public function text(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function style(?Style $style): self
    {
        $this->style = $style;

        return $this;
    }
}
