<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

class ConversationSelectMenu extends SelectMenu
{
    /** @var string */
    private $initialConversation;

    /**
     * @param string $initialConversation
     * @return static
     */
    public function initialConversation(string $initialConversation): self
    {
        $this->initialConversation = $initialConversation;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->initialConversation)) {
            $data['initial_conversation'] = $this->initialConversation;
        }

        return $data;
    }
}
