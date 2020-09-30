<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

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
}
