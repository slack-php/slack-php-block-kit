<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Collections;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Elements\RichTexts\Text;

/**
 * @extends ComponentCollection<Text>
 */
class TextCollection extends ComponentCollection
{
    protected static function createComponent(array $data): Component
    {
        return Text::fromArray($data);
    }

    /**
     * @param array<Text|self|string|null> $elements
     */
    public function __construct(array $elements = [])
    {
        $this->append(...$elements);
    }

    public function append(Text|self|string|null ...$elements): void
    {
        $this->add($elements);
    }

    public function prepend(Text|self|string|null ...$elements): void
    {
        $this->add($elements, true);
    }

    protected function prepareItems(array $items): iterable
    {
        foreach ($items as $text) {
            if ($text instanceof Text) {
                yield $text;
            } elseif ($text instanceof self) {
                yield from $text;
            } elseif (is_string($text)) {
                yield Text::wrap($text);
            }
        }
    }
}
