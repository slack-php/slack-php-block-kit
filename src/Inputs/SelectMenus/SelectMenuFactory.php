<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Inputs\SelectMenus;

class SelectMenuFactory extends MenuFactory
{
    public function forStaticOptions(): StaticSelectMenu
    {
        return $this->create(StaticSelectMenu::class);
    }

    public function forExternalOptions(): ExternalSelectMenu
    {
        return $this->create(ExternalSelectMenu::class);
    }

    public function forUsers(): UserSelectMenu
    {
        return $this->create(UserSelectMenu::class);
    }

    public function forChannels(): ChannelSelectMenu
    {
        return $this->create(ChannelSelectMenu::class);
    }

    public function forConversations(): ConversationSelectMenu
    {
        return $this->create(ConversationSelectMenu::class);
    }
}
