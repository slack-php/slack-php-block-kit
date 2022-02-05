<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Elements\Element;
use SlackPhp\BlockKit\Parts\{Text, Fields};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Validation\{RequiresAnyOf, ValidString};

#[RequiresAnyOf('text', 'fields')]
class Section extends Block
{
    #[Property, ValidString(3000)]
    public ?Text $text;

    #[Property]
    public ?Fields $fields;

    #[Property]
    public ?Element $accessory;

    public function __construct(
        Text|string|null $text = null,
        Fields|array|null $fields = null,
        ?Element $accessory = null,
        ?string $blockId = null
    ) {
        parent::__construct($blockId);
        $this->text($text);
        $this->fields($fields);
        $this->accessory($accessory);
    }

    public function text(Text|string|null $text): self
    {
        $this->text = Text::wrap($text);

        return $this;
    }

    public function fields(Fields|iterable|null $fields): self
    {
        $this->fields = Fields::wrap($fields);

        return $this;
    }

    public function accessory(?Element $accessory): self
    {
        $this->accessory = $accessory;

        return $this;
    }
}
