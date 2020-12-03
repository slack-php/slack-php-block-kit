<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

use Jeremeamia\Slack\BlockKit\HydrationData;

class MultiConversationSelectMenu extends MultiSelectMenu
{
    /** @var string[] */
    private $initialConversations;

    /** @var bool */
    private $defaultToCurrentConversation;

    /**
     * @param string[] $initialConversations
     * @return static
     */
    public function initialConversations(array $initialConversations): self
    {
        $this->initialConversations = $initialConversations;

        return $this;
    }

    /**
     * @param bool $enabled
     * @return static
     */
    public function defaultToCurrentConversation(bool $enabled): self
    {
        $this->defaultToCurrentConversation = $enabled;

        return $this;
    }

    // @TODO: filter - https://api.slack.com/reference/block-kit/block-elements#conversation_select

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->initialConversations)) {
            $data['initial_conversations'] = $this->initialConversations;
        }

        if (!empty($this->defaultToCurrentConversation)) {
            $data['default_to_current_conversation'] = $this->defaultToCurrentConversation;
        }

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('initial_conversations')) {
            $this->initialConversations($data->useArray('initial_conversations'));
        }

        if ($data->has('default_to_current_conversation')) {
            $this->defaultToCurrentConversation($data->useValue('default_to_current_conversation'));
        }

        parent::hydrate($data);
    }
}
