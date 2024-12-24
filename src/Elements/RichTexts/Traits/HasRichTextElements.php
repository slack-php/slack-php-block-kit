<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts\Traits;

use SlackPhp\BlockKit\Collections\RichTextCollection;
use SlackPhp\BlockKit\Elements\RichTexts\RichTextElement;
use SlackPhp\BlockKit\Elements\RichTexts\Text;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\ValidCollection;

trait HasRichTextElements
{
    #[Property, ValidCollection]
    public ?RichTextCollection $elements;

    public function elements(RichTextCollection|RichTextElement|string|null ...$elements): self
    {
        $elements = array_map(fn (mixed $el) => is_string($el) ? Text::wrap($el) : $el, $elements);
        $this->elements->append(...$elements);

        return $this;
    }
}
