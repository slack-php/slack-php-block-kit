<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Inputs\SelectMenus;

use SlackPhp\BlockKit\HydrationData;
use SlackPhp\BlockKit\Partials\Option;

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

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('initial_option')) {
            $this->initialOption = Option::fromArray($data->useElement('initial_option'));
        }

        if ($data->has('min_query_length')) {
            $this->minQueryLength($data->useValue('min_query_length'));
        }

        parent::hydrate($data);
    }
}
