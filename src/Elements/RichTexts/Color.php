<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;
use SlackPhp\BlockKit\Validation\ValidString;

/**
 * @see https://api.slack.com/reference/block-kit/blocks#color-element-type
 */
#[RequiresAllOf('value')]
class Color extends RichTextElement
{
    #[Property, ValidString]
    public ?string $value;

    public function __construct(?string $value = null)
    {
        parent::__construct();
        $this->value($value);
    }

    public function value(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
