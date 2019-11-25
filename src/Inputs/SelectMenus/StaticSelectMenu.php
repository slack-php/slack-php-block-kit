<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

use Jeremeamia\Slack\BlockKit\Partials\HasOptionGroups;
use Jeremeamia\Slack\BlockKit\Partials\Option;

class StaticSelectMenu extends SelectMenu
{
    use HasOptionGroups;

    /** @var Option */
    private $initialOption;

    /**
     * @param string $name
     * @param string $value
     * @return self
     */
    public function initialOption(string $name, string $value): self
    {
        $this->initialOption = new Option($name, $value);
        $this->initialOption->setParent($this);

        return $this;
    }

    public function validate(): void
    {
        parent::validate();

        $this->validateOptionGroups();

        if (!empty($this->initialOption)) {
            $this->initialOption->validate();
        }
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data += $this->getOptionGroupsAsArray();

        if (!empty($this->initialOption)) {
            $data['initial_option'] = $this->initialOption->toArray();
        }

        return $data;
    }
}
