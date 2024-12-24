<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Collections;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Elements\RichTexts\RichTextSubElement;

/**
 * @extends ComponentCollection<RichTextSubElement>
 */
class RichTextSubCollection extends ComponentCollection
{
    protected static function createComponent(array $data): Component
    {
        return RichTextSubElement::fromArray($data);
    }

    /**
     * @param array<RichTextSubElement|self|null> $elements
     */
    public function __construct(array $elements = [])
    {
        $this->append(...$elements);
    }

    public function append(RichTextSubElement|self|null ...$elements): void
    {
        $this->add($elements);
    }

    public function prepend(RichTextSubElement|self|null ...$elements): void
    {
        $this->add($elements, true);
    }

    protected function prepareItems(array $items): iterable
    {
        foreach ($items as $element) {
            if ($element instanceof RichTextSubElement) {
                yield $element;
            } elseif ($element instanceof self) {
                yield from $element;
            }
        }
    }
}
