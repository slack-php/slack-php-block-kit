<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Collections\TextCollection;
use SlackPhp\BlockKit\Elements\RichTexts\Traits\HasBorder;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;
use SlackPhp\BlockKit\Validation\ValidCollection;

/**
 * @see https://api.slack.com/reference/block-kit/blocks#rich_text_preformatted
 */
#[RequiresAllOf('elements')]
class RichTextPreformatted extends RichTextSubElement
{
    use HasBorder;

    #[Property, ValidCollection]
    public ?TextCollection $elements;

    /**
     * @param TextCollection|array<TextCollection|Text|string|null> $elements
     */
    public function __construct(TextCollection|array $elements = [], ?int $border = null)
    {
        parent::__construct();
        $this->elements = new TextCollection();
        $this->elements(...$elements);
        $this->border($border);
    }

    public function elements(TextCollection|Text|string|null ...$elements): self
    {
        $elements = array_map(fn (mixed $el) => is_string($el) ? Text::wrap($el) : $el, $elements);
        $this->elements->append(...$elements);

        return $this;
    }
}
