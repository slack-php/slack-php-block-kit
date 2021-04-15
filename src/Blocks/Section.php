<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\{
    Element,
    Exception,
    HydrationData,
    Inputs,
    Kit,
    Partials,
    Type,
};

class Section extends BlockElement
{
    /** @var Partials\Text */
    private $text;

    /** @var Partials\Fields */
    private $fields;

    /** @var Element */
    private $accessory;

    /**
     * @param string|null $blockId
     * @param string|null $text
     */
    public function __construct(?string $blockId = null, ?string $text = null)
    {
        parent::__construct($blockId);

        if (!empty($text)) {
            $this->mrkdwnText($text);
        }
    }

    /**
     * @param Partials\Text $text
     * @return self
     */
    public function setText(Partials\Text $text): self
    {
        $this->text = $text->setParent($this);

        return $this;
    }

    /**
     * @param Partials\Fields $fields
     * @return self
     */
    public function setFields(Partials\Fields $fields): self
    {
        $this->fields = $fields->setParent($this);

        return $this;
    }

    /**
     * @param Element $accessory
     * @return self
     */
    public function setAccessory(Element $accessory): self
    {
        if (!empty($this->accessory)) {
            throw new Exception('Section accessory already set as type %s', [$this->accessory->getType()]);
        }

        if (!in_array($accessory->getType(), Type::ACCESSORY_ELEMENTS)) {
            throw new Exception('Invalid section accessory type: %s', [$accessory->getType()]);
        }

        $this->accessory = $accessory->setParent($this);

        return $this;
    }

    /**
     * @param string $text
     * @param bool $emoji
     * @return self
     */
    public function plainText(string $text, ?bool $emoji = null): self
    {
        return $this->setText(new Partials\PlainText($text, $emoji));
    }

    /**
     * @param string $text
     * @param bool|null $verbatim
     * @return self
     */
    public function mrkdwnText(string $text, ?bool $verbatim = null): self
    {
        return $this->setText(new Partials\MrkdwnText($text, $verbatim));
    }

    /**
     * @param string $code
     * @return self
     */
    public function code(string $code): self
    {
        return $this->mrkdwnText(Kit::formatter()->codeBlock($code), true);
    }

    /**
     * @param string[] $values
     * @return self
     */
    public function fieldList(array $values): self
    {
        return $this->setFields(new Partials\Fields($values));
    }

    /**
     * @param array $keyValuePairs
     * @return self
     */
    public function fieldMap(array $keyValuePairs): self
    {
        $fields = new Partials\Fields();
        foreach ($keyValuePairs as $key => $value) {
            $fields->add(new Partials\MrkdwnText($key));
            $fields->add(new Partials\MrkdwnText($value));
        }

        return $this->setFields($fields);
    }

    public function newImageAccessory(): Image
    {
        $accessory = new Image();
        $this->setAccessory($accessory);

        return $accessory;
    }

    public function newButtonAccessory(?string $actionId = null): Inputs\Button
    {
        $accessory = new Inputs\Button($actionId);
        $this->setAccessory($accessory);

        return $accessory;
    }

    public function newDatePickerAccessory(?string $actionId = null): Inputs\DatePicker
    {
        $action = new Inputs\DatePicker($actionId);
        $this->setAccessory($action);

        return $action;
    }

    public function newSelectMenuAccessory(?string $actionId = null): Inputs\SelectMenus\SelectMenuFactory
    {
        return new Inputs\SelectMenus\SelectMenuFactory($actionId, function (Inputs\SelectMenus\SelectMenu $menu) {
            $this->setAccessory($menu);
        });
    }

    public function newMultiSelectMenuAccessory(?string $actionId = null): Inputs\SelectMenus\MultiSelectMenuFactory
    {
        return new Inputs\SelectMenus\MultiSelectMenuFactory($actionId, function (Inputs\SelectMenus\SelectMenu $menu) {
            $this->setAccessory($menu);
        });
    }

    public function newTextInputAccessory(?string $actionId = null): Inputs\TextInput
    {
        $action = new Inputs\TextInput($actionId);
        $this->setAccessory($action);

        return $action;
    }

    public function newRadioButtonsAccessory(?string $actionId = null): Inputs\RadioButtons
    {
        $action = new Inputs\RadioButtons($actionId);
        $this->setAccessory($action);

        return $action;
    }

    public function newCheckboxesAccessory(?string $actionId = null): Inputs\Checkboxes
    {
        $action = new Inputs\Checkboxes($actionId);
        $this->setAccessory($action);

        return $action;
    }

    public function newOverflowMenuAccessory(?string $actionId = null): Inputs\OverflowMenu
    {
        $action = new Inputs\OverflowMenu($actionId);
        $this->setAccessory($action);

        return $action;
    }

    public function validate(): void
    {
        if (empty($this->text) && empty($this->fields)) {
            throw new Exception('Section must contain at least a "text" or "fields" item');
        }

        if (!empty($this->text)) {
            $this->text->validate();
        }

        if (!empty($this->fields)) {
            $this->fields->validate();
        }

        if (!empty($this->accessory)) {
            $this->accessory->validate();
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->text)) {
            $data['text'] = $this->text->toArray();
        }

        if (!empty($this->fields)) {
            $data['fields'] = $this->fields->toArray();
        }

        if (!empty($this->accessory)) {
            $data['accessory'] = $this->accessory->toArray();
        }

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('text')) {
            $this->setText(Partials\Text::fromArray($data->useElement('text')));
        }

        if ($data->has('fields')) {
            $this->setFields(Partials\Fields::fromArray($data->useElements('fields')));
        }

        if ($data->has('accessory')) {
            $this->setAccessory(Inputs\InputElement::fromArray($data->useElement('accessory')));
        }

        parent::hydrate($data);
    }
}
