<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Partials;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\HydrationData;

trait HasOptionGroups
{
    use HasOptions;

    /** @var OptionGroup[] */
    private $optionGroups;

    /**
     * @param OptionGroup $group
     * @return static
     */
    public function addOptionGroup(OptionGroup $group): self
    {
        $group->setParent($this);
        $this->optionGroups[] = $group;

        return $this;
    }

    /**
     * @param array<string, array<string, string>|string[]> $optionGroups
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
     * @param array<string, string>|string[] $options
     * @return static
     */
    public function optionGroup(string $label, array $options): self
    {
        return $this->addOptionGroup(OptionGroup::new($label, $options));
    }

    protected function validateOptionGroups(): void
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

    protected function hydrateOptionGroups(HydrationData $data): void
    {
        if ($data->has('option_groups')) {
            foreach ($data->useElements('option_groups') as $optionGroup) {
                $this->addOptionGroup(OptionGroup::fromArray($optionGroup));
            }
        }

        $this->hydrateOptions($data);
    }
}
