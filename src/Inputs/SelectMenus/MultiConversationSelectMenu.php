<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

class MultiConversationSelectMenu extends SelectMenu
{
    /** @var string[] */
    private $initialConversations;

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
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->initialConversations)) {
            $data['initial_conversations'] = $this->initialConversations;
        }

        return $data;
    }
}
