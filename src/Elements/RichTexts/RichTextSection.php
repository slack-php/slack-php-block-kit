<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Collections\RichTextCollection;
use SlackPhp\BlockKit\Elements\RichTexts\Traits\HasRichTextElements;
use SlackPhp\BlockKit\Validation\RequiresAllOf;

#[RequiresAllOf('elements')]
class RichTextSection extends RichTextSubElement
{
    use HasRichTextElements;

    public static function wrap(self|string|null $section): ?self
    {
        return is_string($section) ? new self([$section]) : $section;
    }

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
