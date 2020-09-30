<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

use Jeremeamia\Slack\BlockKit\Partials\Option;

class ExternalSelectMenu extends SelectMenu
{
    /** @var Option */
    private $initialOption;

    /** @var int */
    private $minQueryLength;

    /**
     * @param string $name
     * @param string $value
     * @return self
     */
    public function initialOption(string $name, string $value): self
    {
        $this->initialOption = Option::new($name, $value);
        $this->initialOption->setParent($this);

        return $this;
    }

    public function minQueryLength(int $minQueryLength): self
    {
        $this->minQueryLength = $minQueryLength;

        return $this;
    }

    public function validate(): void
    {
        parent::validate();

        if (!empty($this->initialOption)) {
            $this->initialOption->validate();
        }
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->initialOption)) {
            $data['initial_option'] = $this->initialOption->toArray();
        }

        if (isset($this->minQueryLength)) {
            $data['min_query_length'] = $this->minQueryLength;
        }

        return $data;
    }
}
