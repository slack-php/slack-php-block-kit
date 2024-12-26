<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;
use SlackPhp\BlockKit\Validation\ValidDateFormat;
use SlackPhp\BlockKit\Validation\ValidString;
use SlackPhp\BlockKit\Validation\ValidUrl;

/**
 * @see https://api.slack.com/reference/block-kit/blocks#date-element-type
 */
#[RequiresAllOf('timestamp', 'format')]
class Date extends RichTextElement
{
    #[Property]
    public ?int $timestamp;

    #[Property, ValidDateFormat]
    public ?string $format;

    #[Property, ValidUrl]
    public ?string $url;

    #[Property, ValidString]
    public ?string $fallback;

    public function __construct(
        ?int $timestamp = null,
        ?string $format = null,
        ?string $url = null,
        ?string $fallback = null,
    ) {
        parent::__construct();
        $this->timestamp($timestamp);
        $this->format($format);
        $this->url($url);
        $this->fallback($fallback);
    }

    public function timestamp(?int $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function format(?string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function url(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function fallback(?string $fallback): self
    {
        $this->fallback = $fallback;

        return $this;
    }
}
