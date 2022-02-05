<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Parts\{Confirm, PlainText};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Validation\ValidInt;

abstract class MultiSelectMenu extends Menu
{
    #[Property('max_selected_items'), ValidInt]
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
}
