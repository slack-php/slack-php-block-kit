<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Collections;

use SlackPhp\BlockKit\Elements\Element;

/**
 * @extends ComponentCollection<Element>
 */
class ElementCollection extends ComponentCollection
{
    protected static function createComponent(array $data): Element
    {
        return Element::fromArray($data);
    }

    /**
     * @param array<Element|self|null> $elements
     */
    public function __construct(array $elements = [])
    {
        $this->append(...$elements);
    }

    public function append(Element|self|null ...$elements): void
    {
        $this->add($elements, false);
    }

    public function prepend(Element|self|null ...$elements): void
    {
        $this->add($elements, true);
    }

    protected function prepareItems(array $items): iterable
    {
        foreach ($items as $element) {
            if ($element instanceof Element) {
                yield $element;
            } elseif ($element instanceof self) {
                yield from $element;
            }
        }
    }
}
