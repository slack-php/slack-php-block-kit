<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Partials;

class PlainText extends Text
{
    /** @var bool */
    private $emoji;

    /**
     * @param string $text
     * @param bool $emoji
     */
    public function __construct(string $text, bool $emoji = true)
    {
        $this->text($text);
        $this->emoji($emoji);
    }

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
