<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Parts\{Confirm, PlainText};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\{RequiresAllOf, ValidCollection};

#[RequiresAllOf('placeholder')]
class MultiChannelSelectMenu extends MultiSelectMenu
{
    /** @var array<string>|null */
    #[Property('initial_channels'), ValidCollection]
    public ?array $initialChannels;

    /**
     * @param array<string>|null $initialChannels
     */
    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        ?array $initialChannels = null,
        ?int $maxSelectedItems = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $placeholder, $maxSelectedItems, $confirm, $focusOnLoad);
        $this->initialChannels($initialChannels);
    }

    /**
     * @param array<string>|null $initialChannels
     */
    public function initialChannels(?array $initialChannels): self
    {
        $this->initialChannels = $initialChannels;

        return $this;
    }
}
