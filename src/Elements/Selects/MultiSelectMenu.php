<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Tools\Validator;

abstract class MultiSelectMenu extends Menu
{
    protected ?int $maxSelectedItems;

    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        ?int $maxSelectedItems = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $placeholder, $confirm, $focusOnLoad);
        $this->maxSelectedItems($maxSelectedItems);
    }

    public function maxSelectedItems(?int $maxSelectedItems): static
    {
        $this->maxSelectedItems = $maxSelectedItems;

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->validateInt('max_selected_items');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'max_selected_items' => $this->maxSelectedItems,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->maxSelectedItems($data->useValue('max_selected_items'));
        parent::hydrateFromArrayData($data);
    }
}
