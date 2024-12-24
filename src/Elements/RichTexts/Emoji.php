<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;
use SlackPhp\BlockKit\Validation\ValidString;

/**
 * @see https://api.slack.com/reference/block-kit/blocks#emoji-element-type
 */
#[RequiresAllOf('name')]
class Emoji extends RichTextElement
{
    #[Property, ValidString]
    public ?string $name;

    #[Property, ValidString]
    public ?string $unicode;

    public function __construct(?string $name = null, ?string $unicode = null)
    {
        parent::__construct();
        $this->name($name);
        $this->unicode($unicode);
    }

    public function name(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function unicode(?string $unicode): self
    {
        $this->unicode = $unicode;

        return $this;
    }
}
