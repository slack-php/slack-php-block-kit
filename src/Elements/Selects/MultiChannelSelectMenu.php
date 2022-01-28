<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Tools\Validator;

class MultiChannelSelectMenu extends MultiSelectMenu
{
    /** @var array<string>|null */
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

    protected function validateInternalData(Validator $validator): void
    {
        $validator->validateCollection('initial_channels', $this->maxSelectedItems ?? 0);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'initial_channels' => $this->initialChannels
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->initialChannels($data->useArray('initial_channels'));
        parent::hydrateFromArrayData($data);
    }
}
