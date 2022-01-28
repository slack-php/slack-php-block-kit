<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Traits;

use SlackPhp\BlockKit\Enums\OptionType;
use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Tools\OptionFactory;

trait HasOptionsFactory
{
    protected OptionFactory $optionFactory;

    protected function optionType(OptionType $optionType): static
    {
        if (isset($this->optionFactory)) {
            throw new Exception('OptionType is already set for this component');
        }

        $this->optionFactory = new OptionFactory($optionType);

        return $this;
    }
}
