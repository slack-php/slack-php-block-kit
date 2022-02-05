<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Collections\ActionsCollection;
use SlackPhp\BlockKit\Elements\{
    Button,
    Checkboxes,
    DatePicker,
    OverflowMenu,
    RadioButtons,
    TimePicker,
};
use SlackPhp\BlockKit\Elements\Selects\SelectMenu;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Validation\{RequiresAllOf, ValidCollection};

#[RequiresAllOf('elements')]
class Actions extends Block
{
    #[Property, ValidCollection(5, uniqueIds: true)]
    public ActionsCollection $elements;

    /**
     * @param ActionsCollection|array<Button|Checkboxes|DatePicker|OverflowMenu|RadioButtons|SelectMenu|TimePicker|null> $elements
     */
    public function __construct(ActionsCollection|array $elements = [], ?string $blockId = null)
    {
        parent::__construct($blockId);
        $this->elements = new ActionsCollection();
        $this->elements(...$elements);
    }

    public function elements(
        ActionsCollection|Button|Checkboxes|DatePicker|OverflowMenu|RadioButtons|SelectMenu|TimePicker|null ...$elements
    ): self {
        $this->elements->append(...$elements);

        return $this;
    }
}
