<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\{
    Element,
    Exception,
    HydrationData,
    Inputs,
    Partials,
    Type,
};

/**
 * A block that collects information from users.
 *
 * @see https://api.slack.com/reference/block-kit/blocks#input
 */
class Input extends BlockElement
{
    /** @var Partials\PlainText */
    private $label;

    /** @var Element */
    private $element;

    /** @var Partials\PlainText */
    private $hint;

    /** @var bool */
    private $optional;

    /** @var bool */
    private $dispatchAction;

    /**
     * @param string|null $blockId
     * @param string|null $label
     * @param Element|null $element
     */
    public function __construct(?string $blockId = null, ?string $label = null, ?Element $element = null)
    {
        parent::__construct($blockId);

        if (!empty($label)) {
            $this->label($label);
        }

        if (!empty($element)) {
            $this->setElement($element);
        }

        $this->optional = false;
        $this->dispatchAction = false;
    }

    public function setLabel(Partials\PlainText $label): self
    {
        $this->label = $label->setParent($this);

        return $this;
    }

    public function setElement(Element $element): self
    {
        if (!empty($this->element)) {
            throw new Exception('Input element already set as type %s', [$this->element->getType()]);
        }

        if (!in_array($element->getType(), Type::INPUT_ELEMENTS)) {
            throw new Exception('Invalid input element type: %s', [$element->getType()]);
        }

        $this->element = $element->setParent($this);

        return $this;
    }

    public function setHint(Partials\PlainText $hint): self
    {
        $this->hint = $hint->setParent($this);

        return $this;
    }

    public function label(string $text, ?bool $emoji = null): self
    {
        return $this->setLabel(new Partials\PlainText($text, $emoji));
    }

    public function hint(string $text, ?bool $emoji = null): self
    {
        return $this->setHint(new Partials\PlainText($text, $emoji));
    }

    public function optional(bool $optional = true): self
    {
        $this->optional = $optional;

        return $this;
    }

    public function dispatchAction(bool $dispatchAction = true): self
    {
        $this->dispatchAction = $dispatchAction;

        return $this;
    }

    public function newDatePicker(?string $actionId = null): Inputs\DatePicker
    {
        $action = new Inputs\DatePicker($actionId);
        $this->setElement($action);

        return $action;
    }

    public function newSelectMenu(?string $actionId = null): Inputs\SelectMenus\SelectMenuFactory
    {
        return new Inputs\SelectMenus\SelectMenuFactory($actionId, function (Inputs\SelectMenus\SelectMenu $menu) {
            $this->setElement($menu);
        });
    }

    public function newMultiSelectMenu(?string $actionId = null): Inputs\SelectMenus\MultiSelectMenuFactory
    {
        return new Inputs\SelectMenus\MultiSelectMenuFactory($actionId, function (Inputs\SelectMenus\SelectMenu $menu) {
            $this->setElement($menu);
        });
    }

    public function newTextInput(?string $actionId = null): Inputs\TextInput
    {
        $action = new Inputs\TextInput($actionId);
        $this->setElement($action);

        return $action;
    }

    public function newRadioButtons(?string $actionId = null): Inputs\RadioButtons
    {
        $action = new Inputs\RadioButtons($actionId);
        $this->setElement($action);

        return $action;
    }

    public function newCheckboxes(?string $actionId = null): Inputs\Checkboxes
    {
        $action = new Inputs\Checkboxes($actionId);
        $this->setElement($action);

        return $action;
    }

    public function validate(): void
    {
        if (empty($this->label)) {
            throw new Exception('Input must contain a "label"');
        }

        if (empty($this->element)) {
            throw new Exception('Input must contain an "element"');
        }

        $this->label->validate();
        $this->element->validate();

        if (!empty($this->hint)) {
            $this->hint->validate();
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        $data['label'] = $this->label->toArray();
        $data['element'] = $this->element->toArray();

        if (!empty($this->hint)) {
            $data['hint'] = $this->hint->toArray();
        }

        if ($this->optional) {
            $data['optional'] = $this->optional;
        }

        if ($this->dispatchAction) {
            $data['dispatch_action'] = $this->dispatchAction;
        }

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('label')) {
            $this->setLabel(Partials\PlainText::fromArray($data->useElement('label')));
        }

        if ($data->has('element')) {
            $this->setElement(Inputs\InputElement::fromArray($data->useElement('element')));
        }

        if ($data->has('hint')) {
            $this->setHint(Partials\PlainText::fromArray($data->useElement('hint')));
        }

        if ($data->has('optional')) {
            $this->optional($data->useValue('optional'));
        }

        if ($data->has('dispatch_action')) {
            $this->dispatchAction($data->useValue('dispatch_action'));
        }

        parent::hydrate($data);
    }
}
