<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Collections\RichTextCollection;
use SlackPhp\BlockKit\Elements\RichTexts\Traits\HasBorder;
use SlackPhp\BlockKit\Elements\RichTexts\Traits\HasRichTextElements;
use SlackPhp\BlockKit\Validation\RequiresAllOf;

/**
 * @see https://api.slack.com/reference/block-kit/blocks#rich_text_quote
 */
#[RequiresAllOf('elements')]
class RichTextQuote extends RichTextSubElement
{
    use HasBorder;
    use HasRichTextElements;

    /**
     * @param RichTextCollection|array<RichTextCollection|RichTextElement|string|null> $elements
     */
    public function __construct(RichTextCollection|array $elements = [], ?int $border = null)
    {
        parent::__construct();
        $this->elements = new RichTextCollection();
        $this->elements(...$elements);
        $this->border($border);
    }
}
