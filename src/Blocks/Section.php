<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Blocks;

use Jeremeamia\Slack\BlockKit\Element;
use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Partials\{Fields, MrkdwnText, PlainText, Text};
use Jeremeamia\Slack\BlockKit\Type;

class Section extends Block
{
    /** @var Text */
    private $text;

    /** @var Fields */
    private $fields;

    /** @var Element */
    private $accessory;

    public function setText(Text $text): self
    {
        $this->text = $text->setParent($this);

        return $this;
    }

    public function setFields(Fields $fields): self
    {
        $this->fields = $fields->setParent($this);

        return $this;
    }

    public function setAccessory(Element $accessory): self
    {
        if (!in_array($accessory->getType(), [Type::BUTTON, Type::IMAGE])) {
            throw new Exception("Invalid section accessory type: {$accessory->getType()}");
        }

        $this->accessory = $accessory->setParent($this);

        return $this;
    }

    public function plainText(string $text, bool $emoji = true): self
    {
        $text = PlainText::new()->text($text)->emoji($emoji);

        return $this->setText($text);
    }

    public function mrkdwnText(string $text, bool $verbatim = false): self
    {
        $text = MrkdwnText::new()->text($text)->verbatim($verbatim);

        return $this->setText($text);
    }

    public function fieldList(array $values): self
    {
        $fields = Fields::new();
        foreach ($values as $value) {
            $fields->add(MrkdwnText::new()->text($value));
        }

        return $this->setFields($fields);
    }

    public function fieldMap(array $keyValuePairs): self
    {
        $fields = Fields::new();
        foreach ($keyValuePairs as $key => $value) {
            $fields->add(MrkdwnText::new()->text($key));
            $fields->add(MrkdwnText::new()->text($value));
        }

        return $this->setFields($fields);
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
