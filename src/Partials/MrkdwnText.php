<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Partials;

class MrkdwnText extends Text
{
    /** @var bool */
    private $verbatim = false;

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
}
