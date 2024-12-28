<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Collections\RichTextSubCollection;
use SlackPhp\BlockKit\Elements\RichTexts\RichTextSubElement;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;
use SlackPhp\BlockKit\Validation\ValidCollection;

/**
 * @see https://api.slack.com/reference/block-kit/blocks#rich_text
 */
#[RequiresAllOf('elements')]
class RichText extends Block
{
    #[Property, ValidCollection]
    public RichTextSubCollection $elements;

    /**
     * @param RichTextSubCollection|array<RichTextSubCollection|RichTextSubElement|null> $elements
     */
    public function __construct(RichTextSubCollection|array $elements = [], ?string $blockId = null)
    {
        parent::__construct($blockId);
        $this->elements = new RichTextSubCollection();
        $this->elements(...$elements);
    }

    public function elements(RichTextSubCollection|RichTextSubElement|null ...$elements): self
    {
        $this->elements->append(...$elements);

        return $this;
    }
}
