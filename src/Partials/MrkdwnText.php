<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Partials;

use SlackPhp\BlockKit\HydrationData;
use SlackPhp\BlockKit\Kit;

class MrkdwnText extends Text
{
    /** @var bool */
    private $verbatim;

    /**
     * @param string|null $text
     * @param bool|null $verbatim
     */
    public function __construct(?string $text = null, ?bool $verbatim = null)
    {
        if ($text !== null) {
            $this->text($text);
        }

        $verbatim = $verbatim ?? Kit::config()->getDefaultVerbatimSetting();
        $this->verbatim($verbatim);
    }

    /**
     * @param bool|null $verbatim
     * @return static
     */
    public function verbatim(?bool $verbatim): self
    {
        $this->verbatim = $verbatim;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (isset($this->verbatim)) {
            $data['verbatim'] = $this->verbatim;
        }

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        $this->verbatim($data->useValue('verbatim'));

        parent::hydrate($data);
    }
}
