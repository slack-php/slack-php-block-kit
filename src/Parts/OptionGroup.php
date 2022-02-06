<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\Collections\OptionSet;
use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Hydration\OmitType;
use SlackPhp\BlockKit\Validation\{RequiresAllOf, ValidCollection, ValidString};

#[OmitType, RequiresAllOf('label', 'options')]
class OptionGroup extends Component
{
    #[Property, ValidString(75)]
    public ?PlainText $label;

    #[Property, ValidCollection(100)]
    public OptionSet $options;

    /**
     * @param string|null $label
     * @param OptionSet|array<Option|string|null>|array<string, string>|null $options
     */
    public function __construct(?string $label = null, OptionSet|array|null $options = null)
    {
        parent::__construct();
        $this->label($label);
        $this->options($options);
    }

    public function label(PlainText|string|null $label): self
    {
        $this->label = PlainText::wrap($label);

        return $this;
    }

    /**
     * @param OptionSet|array<Option|string|null>|array<string, string>|null $options
     */
    public function options(OptionSet|array|null $options): static
    {
        $this->options = OptionSet::wrap($options);

        return $this;
    }
}
