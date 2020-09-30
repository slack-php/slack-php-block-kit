<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

class ConversationSelectMenu extends SelectMenu
{
    /** @var string */
    private $initialConversation;

    /** @var bool */
    private $responseUrlEnabled;

    /** @var bool */
    private $defaultToCurrentConversation;

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
     * @param bool $enabled
     * @return static
     */
    public function responseUrlEnabled(bool $enabled): self
    {
        $this->responseUrlEnabled = $enabled;

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

        if (!empty($this->initialConversation)) {
            $data['initial_conversation'] = $this->initialConversation;
        }

        if (!empty($this->responseUrlEnabled)) {
            $data['response_url_enabled'] = $this->responseUrlEnabled;
        }

        if (!empty($this->defaultToCurrentConversation)) {
            $data['default_to_current_conversation'] = $this->defaultToCurrentConversation;
        }

        return $data;
    }
}
