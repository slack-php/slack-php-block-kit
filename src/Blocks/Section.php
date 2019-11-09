<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Blocks;

use Jeremeamia\Slack\BlockKit\{Element, Exception, Inputs, Partials, Type};

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

    public function setText(Partials\Text $text): self
    {
        $this->text = $text->setParent($this);

        return $this;
    }

    public function setFields(Partials\Fields $fields): self
    {
        $this->fields = $fields->setParent($this);

        return $this;
    }

    public function setAccessory(Element $accessory): self
    {
        if (!in_array($accessory->getType(), Type::ACCESSORY_ELEMENTS)) {
            throw new Exception("Invalid section accessory type: {$accessory->getType()}");
        }

        $this->accessory = $accessory->setParent($this);

        return $this;
    }

    public function plainText(string $text, bool $emoji = true): self
    {
        return $this->setText(new Partials\PlainText($text, $emoji));
    }

    public function mrkdwnText(string $text, bool $verbatim = false): self
    {
        return $this->setText(new Partials\MrkdwnText($text, $verbatim));
    }

    /**
     * @param string[] $values
     * @return Section
     */
    public function fieldList(array $values): self
    {
        return $this->setFields(new Partials\Fields($values));
    }

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
}
