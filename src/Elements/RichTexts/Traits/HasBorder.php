<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts\Traits;

use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\ValidInt;

trait HasBorder
{
    #[Property, ValidInt(1, 0)]
    public ?int $border;

    public function border(?int $border): self
    {
        $this->border = $border;

        return $this;
    }
}
