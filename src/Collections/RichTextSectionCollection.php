<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Collections;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Elements\RichTexts\RichTextSection;

/**
 * @extends ComponentCollection<RichTextSection>
 */
class RichTextSectionCollection extends ComponentCollection
{
    protected static function createComponent(array $data): Component
    {
        return RichTextSection::fromArray($data);
    }

    /**
     * @param array<RichTextSection|self|string|null> $sections
     */
    public function __construct(array $sections = [])
    {
        $this->append(...$sections);
    }

    public function append(RichTextSection|self|string|null ...$elements): void
    {
        $this->add($elements);
    }

    public function prepend(RichTextSection|self|string|null ...$elements): void
    {
        $this->add($elements, true);
    }


    protected function prepareItems(array $items): iterable
    {
        foreach ($items as $section) {
            if ($section instanceof RichTextSection) {
                yield $section;
            } elseif ($section instanceof self) {
                yield from $section;
            } elseif (is_string($section)) {
                yield RichTextSection::wrap($section);
            }
        }
    }
}
