<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

class MultiChannelSelectMenu extends SelectMenu
{
    /** @var string[] */
    private $initialChannels;

    /**
     * @param string[] $initialChannels
     * @return static
     */
    public function initialChannels(array $initialChannels): self
    {
        $this->initialChannels = $initialChannels;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->initialChannels)) {
            $data['initial_channels'] = $this->initialChannels;
        }

        return $data;
    }
}
