<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\Tools\HydrationData;

class PlainText extends Text
{
    public ?bool $emoji;

    public function __construct(?string $text = null, ?bool $emoji = null)
    {
        parent::__construct($text);
        $this->emoji($emoji);
    }

    public function emoji(?bool $emoji = null): self
    {
        $this->emoji = $emoji;

        return $this;
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'emoji' => $this->emoji,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->emoji($data->useValue('emoji'));
        parent::hydrateFromArrayData($data);
    }
}
