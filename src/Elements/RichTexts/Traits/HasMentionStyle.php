<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts\Traits;

use SlackPhp\BlockKit\Parts\MentionStyle;
use SlackPhp\BlockKit\Property;

trait HasMentionStyle
{
    #[Property]
    public ?MentionStyle $style;

    public function style(?MentionStyle $style): self
    {
        $this->style = $style;

        return $this;
    }
}
