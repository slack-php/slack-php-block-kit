<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Parts\PlainText;

class ChannelSelectMenu extends SelectMenu
{
    public ?string $initialChannel;
    public ?bool $responseUrlEnabled;

    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        ?string $initialChannel = null,
        ?bool $responseUrlEnabled = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $placeholder, $confirm, $focusOnLoad);
        $this->initialChannel($initialChannel);
        $this->responseUrlEnabled($responseUrlEnabled);
    }

    public function initialChannel(?string $initialChannel): self
    {
        $this->initialChannel = $initialChannel;

        return $this;
    }

    public function responseUrlEnabled(?bool $enabled): self
    {
        $this->responseUrlEnabled = $enabled;

        return $this;
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'initial_channel' => $this->initialChannel,
            'response_url_enabled' => $this->responseUrlEnabled,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->initialChannel($data->useValue('initial_channel'));
        $this->responseUrlEnabled($data->useValue('response_url_enabled'));
        parent::hydrateFromArrayData($data);
    }
}
