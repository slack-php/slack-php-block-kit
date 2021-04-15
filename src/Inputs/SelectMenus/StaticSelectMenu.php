<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Inputs\SelectMenus;

use SlackPhp\BlockKit\Partials\{HasOptionGroups, OptionsConfig};
use SlackPhp\BlockKit\HydrationData;

class StaticSelectMenu extends SelectMenu
{
    use HasOptionGroups;

    protected function getOptionsConfig(): OptionsConfig
    {
        return OptionsConfig::new()
            ->setMinOptions(1)
            ->setMaxOptions(100)
            ->setMaxInitialOptions(1);
    }

    public function validate(): void
    {
        parent::validate();

        $this->validateOptionGroups();
        $this->validateInitialOptions();
    }

    public function toArray(): array
    {
        return parent::toArray()
            + $this->getOptionGroupsAsArray()
            + $this->getInitialOptionsAsArray();
    }

    protected function hydrate(HydrationData $data): void
    {
        $this->hydrateOptionGroups($data);
        parent::hydrate($data);
    }
}
