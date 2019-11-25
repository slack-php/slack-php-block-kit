<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

class ChannelSelectMenu extends SelectMenu
{
    /** @var string */
    private $initialChannel;

    /**
     * @param string $initialChannel
     * @return static
     */
    public function initialChannel(string $initialChannel): self
    {
        $this->initialChannel = $initialChannel;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->initialChannel)) {
            $data['initial_channel'] = $this->initialChannel;
        }

        return $data;
    }
}
