<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Parts\Style;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;
use SlackPhp\BlockKit\Validation\ValidString;
use SlackPhp\BlockKit\Validation\ValidUrl;

/**
 * @see https://api.slack.com/reference/block-kit/blocks#link-element-type
 */
#[RequiresAllOf('url')]
class Link extends RichTextElement
{
    #[Property, ValidUrl]
    public ?string $url;

    #[Property, ValidString]
    public ?string $text;

    #[Property]
    public ?bool $unsafe;

    #[Property]
    public ?Style $style;

    public function __construct(
        ?string $url = null,
        ?string $text = null,
        ?bool $unsafe = null,
        ?Style $style = null,
    ) {
        parent::__construct();
        $this->url($url);
        $this->text($text);
        $this->unsafe($unsafe);
        $this->style($style);
    }

    public function url(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function text(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function unsafe(?bool $unsafe): self
    {
        $this->unsafe = $unsafe;

        return $this;
    }

    public function style(?Style $style): self
    {
        $this->style = $style;

        return $this;
    }
}
