<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

use Jeremeamia\Slack\BlockKit\Partials\{HasOptionGroups, OptionsConfig};

class MultiStaticSelectMenu extends MultiSelectMenu
{
    use HasOptionGroups;

    protected function getOptionsConfig(): OptionsConfig
    {
        return OptionsConfig::new()
            ->setMinOptions(1)
            ->setMaxOptions(100)
            ->setMaxInitialOptions($this->maxSelectedItems ?? null);
    }

    public function validate(): void
    {
        parent::validate();
        $this->validateOptionGroups();
        $this->validateInitialOptions();
    }

    public function toArray(): array
    {
        return parent::toArray() + $this->getOptionGroupsAsArray() + $this->getInitialOptionsAsArray();
    }
}
