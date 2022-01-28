<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Collections\ActionsCollection;
use SlackPhp\BlockKit\Tools\{HydrationData, Validator};
use SlackPhp\BlockKit\Elements\{
    Button,
    Checkboxes,
    DatePicker,
    OverflowMenu,
    RadioButtons,
    TimePicker,
};
use SlackPhp\BlockKit\Elements\Selects\SelectMenu;

class Actions extends Block
{
    public ActionsCollection $elements;

    /**
     * @param array<Button|Checkboxes|DatePicker|OverflowMenu|RadioButtons|SelectMenu|TimePicker|null> $elements
     */
    public function __construct(array $elements = [], ?string $blockId = null)
    {
        parent::__construct($blockId);
        $this->elements = new ActionsCollection();
        $this->elements(...$elements);
    }

    public function elements(
        Button|Checkboxes|DatePicker|OverflowMenu|RadioButtons|SelectMenu|TimePicker|null ...$elements
    ): self {
        $this->elements->append(...$elements);

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->validateCollection('elements', max: 5, min: 1);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'elements' => $this->elements->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->elements = ActionsCollection::fromArray($data->useComponents('elements'));
        parent::hydrateFromArrayData($data);
    }
}
