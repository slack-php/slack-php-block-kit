<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Traits;

use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\ValidString;

trait HasPlaceholder
{
    #[Property, ValidString(150)]
    public ?PlainText $placeholder;

    public function placeholder(PlainText|string|null $placeholder): static
    {
        $this->placeholder = PlainText::wrap($placeholder);

        return $this;
    }
}
