<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Collections;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Elements\Image;
use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Parts\Text;

/**
 * @extends ComponentCollection<Image|Text>
 */
class ContextCollection extends ComponentCollection
{
    protected static function createComponent(array $data): Image|Text
    {
        $component = Component::fromArray($data);

        if ($component instanceof Image || $component instanceof Text) {
            return $component;
        }

        throw new Exception('Cannot include a %s component in a Context collection', [$component->type->value]);
    }

    /**
     * @param array<Image|Text|self|null> $elements
     */
    public function __construct(array $elements = [])
    {
        $this->append(...$elements);
    }

    public function append(Image|Text|self|null ...$elements): void
    {
        $this->add($elements, false);
    }

    public function prepend(Image|Text|self|null ...$elements): void
    {
        $this->add($elements, true);
    }

    protected function prepareItems(array $items): iterable
    {
        foreach ($items as $element) {
            if ($element instanceof self) {
                yield from $element;
            } elseif ($element !== null) {
                yield $element;
            }
        }
    }
}
