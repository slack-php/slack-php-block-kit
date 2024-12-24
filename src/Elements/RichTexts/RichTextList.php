<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Collections\RichTextSectionCollection;
use SlackPhp\BlockKit\Elements\RichTexts\Traits\HasBorder;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;
use SlackPhp\BlockKit\Validation\ValidCollection;
use SlackPhp\BlockKit\Validation\ValidInt;

/**
 * @see https://api.slack.com/reference/block-kit/blocks#rich_text_list
 */
#[RequiresAllOf('elements', 'style')]
class RichTextList extends RichTextSubElement
{
    use HasBorder;

    #[Property, ValidCollection]
    public ?RichTextSectionCollection $elements;

    #[Property]
    public ?ListStyle $style;

    #[Property, ValidInt(9, 0)]
    public ?int $indent;

    #[Property, ValidInt(min: 0)]
    public ?int $offset;

    /**
     * @param RichTextSectionCollection|array<RichTextSectionCollection|RichTextSection|string|null> $elements
     */
    public function __construct(
        RichTextSectionCollection|array $elements = [],
        ListStyle|string|null $style = null,
        ?int $indent = null,
        ?int $offset = null,
        ?int $border = null,
    ) {
        parent::__construct();
        $this->elements = new RichTextSectionCollection();
        $this->elements(...$elements);
        $this->style($style);
        $this->indent($indent);
        $this->offset($offset);
        $this->border($border);
    }


    public function elements(RichTextSectionCollection|RichTextSection|string|null ...$elements): self
    {
        $elements = array_map(fn (mixed $el) => is_string($el) ? RichTextSection::wrap($el) : $el, $elements);
        $this->elements->append(...$elements);

        return $this;
    }
    public function style(ListStyle|string|null $style): self
    {
        $this->style = ListStyle::fromValue($style);

        return $this;
    }

    public function indent(?int $indent): self
    {
        $this->indent = $indent;

        return $this;
    }

    public function offset(?int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }
}
