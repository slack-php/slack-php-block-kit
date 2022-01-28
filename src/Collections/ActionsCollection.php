<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Collections;

use SlackPhp\BlockKit\Elements\{
    Button,
    Checkboxes,
    DatePicker,
    OverflowMenu,
    RadioButtons,
    TimePicker,
};
use SlackPhp\BlockKit\Elements\Element;
use SlackPhp\BlockKit\Elements\Selects\SelectMenu;
use SlackPhp\BlockKit\Exception;

/**
 * @extends ComponentCollection<Button|Checkboxes|DatePicker|OverflowMenu|RadioButtons|SelectMenu|TimePicker>
 */
class ActionsCollection extends ComponentCollection
{
    protected static function createComponent(array $data): Button|Checkboxes|DatePicker|OverflowMenu|RadioButtons|SelectMenu|TimePicker
    {
        $element = Element::fromArray($data);

        if ($element instanceof Button
            || $element instanceof Checkboxes
            || $element instanceof  DatePicker
            || $element instanceof OverflowMenu
            || $element instanceof RadioButtons
            || $element instanceof SelectMenu
            || $element instanceof TimePicker
        ) {
            return $element;
        }

        throw new Exception('Cannot include an %s element in an Actions collection', [$element->type->value]);
    }

    /**
     * @param array<Button|Checkboxes|DatePicker|OverflowMenu|RadioButtons|SelectMenu|TimePicker|self|null> $elements
     */
    public function __construct(array $elements = [])
    {
        $this->append(...$elements);
    }

    public function append(Button|Checkboxes|DatePicker|OverflowMenu|RadioButtons|SelectMenu|TimePicker|self|null ...$elements): void
    {
        $this->add($elements, false);
    }

    public function prepend(Button|Checkboxes|DatePicker|OverflowMenu|RadioButtons|SelectMenu|TimePicker|self|null ...$elements): void
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
