<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Inputs\SelectMenus;

class MultiSelectMenuFactory extends MenuFactory
{
    public function forStaticOptions(): MultiStaticSelectMenu
    {
        return $this->create(MultiStaticSelectMenu::class);
    }

    public function forExternalOptions(): MultiExternalSelectMenu
    {
        return $this->create(MultiExternalSelectMenu::class);
    }

    public function forUsers(): MultiUserSelectMenu
    {
        return $this->create(MultiUserSelectMenu::class);
    }

    public function forChannels(): MultiChannelSelectMenu
    {
        return $this->create(MultiChannelSelectMenu::class);
    }

    public function forConversations(): MultiConversationSelectMenu
    {
        return $this->create(MultiConversationSelectMenu::class);
    }
}
