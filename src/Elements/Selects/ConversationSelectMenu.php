<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Parts\Filter;
use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Tools\Validator;

class ConversationSelectMenu extends SelectMenu
{
    public ?string $initialConversation;
    public ?bool $responseUrlEnabled;
    public ?bool $defaultToCurrentConversation;
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

    protected function validateInternalData(Validator $validator): void
    {
        $validator->validateSubComponents('filter');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'initial_conversation' => $this->initialConversation,
            'response_url_enabled' => $this->responseUrlEnabled,
            'default_to_current_conversation' => $this->defaultToCurrentConversation,
            'filter' => $this->filter?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->initialConversation($data->useValue('initial_conversation'));
        $this->responseUrlEnabled($data->useValue('response_url_enabled'));
        $this->defaultToCurrentConversation($data->useValue('default_to_current_conversation'));
        $this->filter(Filter::fromArray($data->useComponent('filter')));
        parent::hydrateFromArrayData($data);
    }
}
