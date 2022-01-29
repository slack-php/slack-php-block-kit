<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Traits;

use SlackPhp\BlockKit\Collections\OptionSet;
use SlackPhp\BlockKit\Parts\Option;
use SlackPhp\BlockKit\Tools\OptionFactory;

trait HasInitialOptions
{
    protected OptionFactory $optionFactory;
    public ?OptionSet $initialOptions = null;

    /**
     * @param OptionSet|array<Option|string|null>|null $options
     */
    public function initialOptions(OptionSet|array|null $options): static
    {
        $this->initialOptions = $this->optionFactory->options($options);

        return $this;
    }

    private function resolveInitialOptions(): void
    {
        if (isset($this->optionGroups)) {
            $initial = $this->optionGroups->getInitial();
        } elseif (isset($this->options)) {
            $initial =  $this->options->getInitial();
        } else {
            $initial = [];
        }

        $initial = [...($this->initialOptions ?? []), ...$initial];

        $this->initialOptions = $this->optionFactory->options($initial);
    }
}
