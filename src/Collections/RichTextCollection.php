<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Collections;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Elements\RichTexts\RichTextElement;
use SlackPhp\BlockKit\Elements\RichTexts\Text;

/**
 * @extends ComponentCollection<RichTextElement>
 */
class RichTextCollection extends ComponentCollection
{
    protected static function createComponent(array $data): Component
    {
        return RichTextElement::fromArray($data);
    }

    /**
     * @param array<RichTextElement|self|string|null> $elements
     */
    public function __construct(array $elements = [])
    {
        $this->append(...$elements);
    }

    public function append(RichTextElement|self|string|null ...$elements): void
    {
        $this->add($elements);
    }

    public function prepend(RichTextElement|self|string|null ...$elements): void
    {
        $this->add($elements, true);
    }

    protected function prepareItems(array $items): iterable
    {
        foreach ($items as $element) {
            if ($element instanceof RichTextElement) {
                yield $element;
            } elseif ($element instanceof self) {
                yield from $element;
            } elseif (is_string($element)) {
                yield Text::wrap($element);
            }
        }
    }
}
