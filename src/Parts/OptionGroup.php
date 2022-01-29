<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Collections\OptionSet;
use SlackPhp\BlockKit\Tools\{HydrationData, Validator};

class OptionGroup extends Component
{
    public ?PlainText $label;
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
        $this->label = PlainText::wrap($label)?->limitLength(75);

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

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireAllOf('label', 'options')
            ->validateCollection('options', 100)
            ->validateSubComponents('label');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'label' => $this->label?->toArray(),
            'options' => $this->options->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->label(PlainText::fromArray($data->useComponent('label')));
        $this->options(OptionSet::fromArray($data->useComponents('options')));
        parent::hydrateFromArrayData($data);
    }
}
