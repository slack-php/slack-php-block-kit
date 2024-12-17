<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Collections\RichTextCollection;
use SlackPhp\BlockKit\Elements\RichTexts\Traits\HasRichTextElements;

class RichTextSection extends RichTextSubElement
{
    use HasRichTextElements;

    /**
     * @param RichTextCollection|array<RichTextCollection|RichTextElement|string|null> $elements
     */
    public function __construct(RichTextCollection|array $elements = [])
    {
        parent::__construct();
        $this->elements = new RichTextCollection();
        $this->elements(...$elements);
    }
}
