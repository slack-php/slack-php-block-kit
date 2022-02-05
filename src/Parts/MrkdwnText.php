<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\Property;

class MrkdwnText extends Text
{
    #[Property]
    public ?bool $verbatim;

    public function __construct(?string $text = null, ?bool $verbatim = null)
    {
        parent::__construct($text);
        $this->verbatim($verbatim);
    }

    public function verbatim(?bool $verbatim = null): self
    {
        $this->verbatim = $verbatim;

        return $this;
    }
}
