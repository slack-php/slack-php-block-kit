<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Partials;

use Jeremeamia\Slack\BlockKit\HydrationData;

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

        if ($emoji !== null) {
            $this->emoji($emoji);
        }
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
        $data = parent::toArray();

        if (isset($this->emoji)) {
            $data['emoji'] = $this->emoji;
        }

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('emoji')) {
            $this->emoji($data->useValue('emoji', true));
        }

        parent::hydrate($data);
    }
}
