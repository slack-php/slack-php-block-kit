<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Partials;

class PlainText extends Text
{
    /** @var bool */
    private $emoji = true;

    /**
     * @param bool $emoji
     * @return static
     */
    public function emoji(bool $emoji): self
    {
        $this->emoji = $emoji;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return parent::toArray() + ['emoji' => $this->emoji];
    }
}
