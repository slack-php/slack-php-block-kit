<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Traits;

use SlackPhp\BlockKit\Parts\{Option, OptionFactory};
use SlackPhp\BlockKit\Property;

trait HasInitialOption
{
    protected OptionFactory $optionFactory;

    #[Property('initial_option')]
    public ?Option $initialOption = null;

    public function initialOption(Option|string|null $option): static
    {
        $this->initialOption = $this->optionFactory->option($option);

        return $this;
    }

    private function resolveInitialOption(): void
    {
        if (isset($this->initialOption)) {
            return;
        }

        if (isset($this->optionGroups)) {
            $initial = $this->optionGroups->getInitial();
        } elseif (isset($this->options)) {
            $initial =  $this->options->getInitial();
        } else {
            $initial = [];
        }

        $this->initialOption = [...$initial][0] ?? null;
    }
}
