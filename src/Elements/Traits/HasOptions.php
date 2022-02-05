<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Traits;

use SlackPhp\BlockKit\Collections\OptionSet;
use SlackPhp\BlockKit\Parts\Option;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\OptionFactory;
use SlackPhp\BlockKit\Tools\Validation\ValidCollection;

trait HasOptions
{
    protected OptionFactory $optionFactory;

    #[Property, ValidCollection(100)]
    public ?OptionSet $options;

    /**
     * @param OptionSet|array<Option|string|null>|array<string, string>|null $options
     */
    public function options(OptionSet|array|null $options): static
    {
        $this->options = $this->optionFactory->options($options);

        return $this;
    }
}
