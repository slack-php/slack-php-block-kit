<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

use Jeremeamia\Slack\BlockKit\Partials\HasOptionGroups;
use Jeremeamia\Slack\BlockKit\Partials\Option;

class MultiStaticSelectMenu extends MultiSelectMenu
{
    use HasOptionGroups;

    /** @var Option[] */
    private $initialOptions;

    /**
     * @param array $options
     * @return self
     */
    public function initialOptions(array $options): self
    {
        foreach ($options as $name => $value) {
            $option = new Option((string) $name, (string) $value);
            $option->setParent($this);
            $this->initialOptions[] = $option;
        }

        return $this;
    }

    public function validate(): void
    {
        parent::validate();

        $this->validateOptionGroups();

        if (!empty($this->initialOptions)) {
            foreach ($this->initialOptions as $option) {
                $option->validate();
            }
        }
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data += $this->getOptionGroupsAsArray();

        if (!empty($this->initialOptions)) {
            $data['initial_options'] = array_map(function (Option $option) {
                return $option->toArray();
            }, $this->initialOptions);
        }

        return $data;
    }
}
