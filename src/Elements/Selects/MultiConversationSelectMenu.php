<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Parts\{Confirm, Filter, PlainText};
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\{RequiresAllOf, ValidCollection};

#[RequiresAllOf('placeholder')]
class MultiConversationSelectMenu extends MultiSelectMenu
{
    /** @var string[]|null */
    #[Property('initial_conversations'), ValidCollection]
    public ?array $initialConversations;

    #[Property('default_to_current_conversation')]
    public ?bool $defaultToCurrentConversation;

    #[Property]
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
}
