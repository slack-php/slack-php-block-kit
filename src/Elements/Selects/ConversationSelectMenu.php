<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Parts\{Confirm, Filter, PlainText};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;

#[RequiresAllOf('placeholder')]
class ConversationSelectMenu extends SelectMenu
{
    #[Property('initial_conversation')]
    public ?string $initialConversation;

    #[Property('response_url_enabled')]
    public ?bool $responseUrlEnabled;

    #[Property('default_to_current_conversation')]
    public ?bool $defaultToCurrentConversation;

    #[Property]
    public ?Filter $filter;

    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        ?string $initialConversation = null,
        ?bool $responseUrlEnabled = null,
        ?bool $defaultToCurrentConversation = null,
        ?Filter $filter = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $placeholder, $confirm, $focusOnLoad);
        $this->initialConversation($initialConversation);
        $this->responseUrlEnabled($responseUrlEnabled);
        $this->defaultToCurrentConversation($defaultToCurrentConversation);
        $this->filter($filter);
    }

    public function initialConversation(?string $initialConversation): self
    {
        $this->initialConversation = $initialConversation;

        return $this;
    }

    public function responseUrlEnabled(?bool $enabled): self
    {
        $this->responseUrlEnabled = $enabled;

        return $this;
    }

    public function defaultToCurrentConversation(?bool $enabled): self
    {
        $this->defaultToCurrentConversation = $enabled;

        return $this;
    }

    public function filter(?Filter $filter): self
    {
        $this->filter = $filter;

        return $this;
    }
}
