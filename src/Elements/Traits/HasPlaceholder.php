<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Traits;

use SlackPhp\BlockKit\Parts\PlainText;

trait HasPlaceholder
{
    public ?PlainText $placeholder;

    public function placeholder(PlainText|string|null $placeholder): static
    {
        $this->placeholder = PlainText::wrap($placeholder)?->limitLength(150);

        return $this;
    }
}
