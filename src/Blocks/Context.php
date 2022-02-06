<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Collections\ContextCollection;
use SlackPhp\BlockKit\Elements\Image;
use SlackPhp\BlockKit\Parts\Text;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\{RequiresAllOf, ValidCollection};

#[RequiresAllOf('elements')]
class Context extends Block
{
    #[Property, ValidCollection(10)]
    public ContextCollection $elements;

    public static function fromText(Text|string $text): self
    {
        return new self([Text::wrap($text)]);
    }

    /**
     * @param ContextCollection|array<Image|Text|string|null> $elements
     */
    public function __construct(ContextCollection|array $elements = [], ?string $blockId = null)
    {
        parent::__construct($blockId);
        $this->elements = new ContextCollection();
        $this->elements(...$elements);
    }

    public function elements(ContextCollection|Image|Text|string|null ...$elements): self
    {
        $elements = array_map(fn (mixed $el) => is_string($el) ? Text::wrap($el) : $el, $elements);
        $this->elements->append(...$elements);

        return $this;
    }
}
