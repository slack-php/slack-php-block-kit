<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Partials;

use Jeremeamia\Slack\BlockKit\{Element, Exception};

class OptionGroup extends Element
{
    use HasOptions;

    /** @var PlainText */
    private $label;

    public function __construct(string $label, array $options)
    {
        $this->label($label);
        $this->options($options);
    }

    /**
     * @param PlainText $label
     * @return self
     */
    public function setLabel(PlainText $label): self
    {
        $this->label = $label->setParent($this);

        return $this;
    }

    /**
     * @param string $label
     * @return static
     */
    public function label(string $label): self
    {
        return $this->setLabel(new PlainText($label, false));
    }

    public function validate(): void
    {
        if (empty($this->label)) {
            throw new Exception('OptionGroup element must contain a "label" element');
        }

        $this->label->validate();
        $this->validateOptions();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return parent::toArray()
            + ['label' => $this->label->toArray()]
            + $this->getOptionsAsArray();
    }
}
