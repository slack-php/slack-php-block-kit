<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Partials;

use Jeremeamia\Slack\BlockKit\Exception;

trait HasOptionGroups
{
    use HasOptions;

    /** @var OptionGroup[] */
    private $optionGroups;

    /**
     * @param array $optionGroups
     * @return static
     */
    public function optionGroups(array $optionGroups): self
    {
        foreach ($optionGroups as $label => $options) {
            $this->optionGroup((string) $label, $options);
        }

        return $this;
    }

    /**
     * @param string $label
     * @param array $options
     * @return static
     */
    public function optionGroup(string $label, array $options): self
    {
        $group = OptionGroup::new($label, $options);
        $group->setParent($this);
        $this->optionGroups[] = $group;

        return $this;
    }

    protected function validateOptionGroups()
    {
        if (!(empty($this->options) xor empty($this->optionGroups))) {
            throw new Exception('You must provide "options" or "option_groups", but not both.');
        }

        if (!empty($this->optionGroups)) {
            foreach ($this->optionGroups as $group) {
                $group->validate();
            }
        } else {
            $this->validateOptions();
        }
    }

    protected function getOptionGroupsAsArray(): array
    {
        if (!empty($this->optionGroups)) {
            return ['option_groups' => array_map(function (OptionGroup $optionGroup) {
                return $optionGroup->toArray();
            }, $this->optionGroups)];
        } else {
            return $this->getOptionsAsArray();
        }
    }
}
