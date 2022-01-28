<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\Tools\HydrationData;

class MrkdwnText extends Text
{
    public ?bool $verbatim;

    public function __construct(?string $text = null, ?bool $verbatim = null)
    {
        parent::__construct($text);
        $this->verbatim($verbatim);
    }

    public function verbatim(?bool $verbatim = null): self
    {
        $this->verbatim = $verbatim;

        return $this;
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'verbatim' => $this->verbatim,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->verbatim($data->useValue('verbatim'));
        parent::hydrateFromArrayData($data);
    }
}
