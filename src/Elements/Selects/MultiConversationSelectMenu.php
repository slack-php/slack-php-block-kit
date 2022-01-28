<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Parts\Filter;
use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Tools\Validator;

class MultiConversationSelectMenu extends MultiSelectMenu
{
    /** @var string[]|null */
    public ?array $initialConversations;
    public ?bool $defaultToCurrentConversation;
    public ?Filter $filter;

    /**
     * @param string[]|null $initialConversations
     */
    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        ?array $initialConversations = null,
        ?bool $defaultToCurrentConversation = null,
        ?Filter $filter = null,
        ?int $maxSelectedItems = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $placeholder, $maxSelectedItems, $confirm, $focusOnLoad);
        $this->initialConversations($initialConversations);
        $this->defaultToCurrentConversation($defaultToCurrentConversation);
        $this->filter($filter);
    }

    /**
     * @param string[]|null $initialConversations
\     */
    public function initialConversations(?array $initialConversations): self
    {
        $this->initialConversations = $initialConversations;

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
        $validator->validateCollection('initial_channels', $this->maxSelectedItems ?? 0)
            ->validateSubComponents('filter');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'initial_conversations' => $this->initialConversations,
            'default_to_current_conversation' => $this->defaultToCurrentConversation,
            'filter' => $this->filter?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->initialConversations($data->useValue('initial_conversations'));
        $this->defaultToCurrentConversation($data->useValue('default_to_current_conversation'));
        $this->filter(Filter::fromArray($data->useComponent('filter')));
        parent::hydrateFromArrayData($data);
    }
}
