<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Collections\ActionCollection;
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
use SlackPhp\BlockKit\Validation\{RequiresAllOf, UniqueIds, ValidCollection};

#[RequiresAllOf('elements')]
class Actions extends Block
{
    #[Property, ValidCollection(5), UniqueIds]
    public ActionCollection $elements;

    /**
     * @param ActionCollection|array<Button|Checkboxes|DatePicker|OverflowMenu|RadioButtons|SelectMenu|TimePicker|null> $elements
     */
    public function __construct(ActionCollection|array $elements = [], ?string $blockId = null)
    {
        parent::__construct($blockId);
        $this->elements = new ActionCollection();
        $this->elements(...$elements);
    }

    public function elements(
        ActionCollection|Button|Checkboxes|DatePicker|OverflowMenu|RadioButtons|SelectMenu|TimePicker|null ...$elements
    ): self {
        $this->elements->append(...$elements);

        return $this;
    }
}
