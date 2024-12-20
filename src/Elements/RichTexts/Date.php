<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;

#[RequiresAllOf('timestamp', 'format')]
class Date extends RichTextElement
{
    #[Property]
    public ?int $timestamp;

    #[Property]
    public ?string $format;

    #[Property]
    public ?string $url;

    #[Property]
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
