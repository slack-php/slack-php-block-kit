<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Partials;

use SlackPhp\BlockKit\HydrationData;
use SlackPhp\BlockKit\Kit;

class PlainText extends Text
{
    /** @var bool|null */
    private $emoji;

    /**
     * @param string|null $text
     * @param bool|null $emoji
     */
    public function __construct(?string $text = null, ?bool $emoji = null)
    {
        if ($text !== null) {
            $this->text($text);
        }

        $emoji = $emoji ?? Kit::config()->getDefaultEmojiSetting();
        $this->emoji($emoji);
    }

    /**
     * @param bool|null $emoji
     * @return static
     */
    public function emoji(?bool $emoji): self
    {
        $this->emoji = $emoji;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (isset($this->emoji)) {
            $data['emoji'] = $this->emoji;
        }

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        $this->emoji($data->useValue('emoji'));

        parent::hydrate($data);
    }
}
