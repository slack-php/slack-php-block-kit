<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\Property;

class PlainText extends Text
{
    #[Property]
    public ?bool $emoji;

    public function __construct(?string $text = null, ?bool $emoji = null)
    {
        parent::__construct($text);
        $this->emoji($emoji);
    }

    public function emoji(?bool $emoji = null): self
    {
        $this->emoji = $emoji;

        return $this;
    }
}
