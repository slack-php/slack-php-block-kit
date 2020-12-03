<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Partials;

use Jeremeamia\Slack\BlockKit\HydrationData;

class MrkdwnText extends Text
{
    /** @var bool */
    private $verbatim;

    /**
     * @param string|null $text
     * @param bool $verbatim
     */
    public function __construct(?string $text = null, bool $verbatim = false)
    {
        if ($text !== null) {
            $this->text($text);
        }

        $this->verbatim($verbatim);
    }

    /**
     * @param bool $verbatim
     * @return static
     */
    public function verbatim(bool $verbatim): self
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

        if (!empty($this->verbatim)) {
            $data['verbatim'] = $this->verbatim;
        }

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        $this->verbatim($data->useValue('verbatim', false));

        parent::hydrate($data);
    }
}
