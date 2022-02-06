<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\{RequiresAllOf, ValidString};

#[RequiresAllOf('text')]
class Header extends Block
{
    #[Property, ValidString(150)]
    public ?PlainText $text;

    public function __construct(PlainText|string|null $text = null, ?string $blockId = null)
    {
        parent::__construct($blockId);
        $this->text($text);
    }

    public function text(PlainText|string|null $text): static
    {
        $this->text = PlainText::wrap($text);

        return $this;
    }
}
