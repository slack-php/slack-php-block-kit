<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Parts\{Confirm, PlainText};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Validation\RequiresAllOf;

#[RequiresAllOf('placeholder')]
class ChannelSelectMenu extends SelectMenu
{
    #[Property('initial_channel')]
    public ?string $initialChannel;

    #[Property('response_url_enabled')]
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
}
