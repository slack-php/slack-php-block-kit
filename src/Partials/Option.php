<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Partials;

use SlackPhp\BlockKit\{Element, Exception, HydrationData, Type};

/**
 * @see https://api.slack.com/reference/block-kit/composition-objects#option
 */
class Option extends Element
{
    /** @var PlainText */
    private $text;

    /** @var string */
    private $value;

    /** @var PlainText Description text for option. NOTE: Radio Button and Checkbox groups only. */
    private $description;

    /** @var string URL to load in browser when option is clicked. NOTE: Overflow Menu only. */
    private $url;

    /**
     * @param string|null $text
     * @param string|null $value
     * @return self
     */
    public static function new(?string $text = null, ?string $value = null): self
    {
        $option = new self();

        if ($text !== null) {
            $option->text($text);
        }

        if ($value !== null) {
            $option->value($value);
        }

        return $option;
    }

    /**
     * @param PlainText $text
     * @return static
     */
    public function setText(PlainText $text): self
    {
        $this->text = $text->setParent($this);

        return $this;
    }

    /**
     * @param string $text
     * @return static
     */
    public function text(string $text): self
    {
        return $this->setText(new PlainText($text));
    }

    /**
     * @param string $value
     * @return static
     */
    public function value(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param PlainText $description
     * @return static
     */
    public function setDescription(PlainText $description): self
    {
        $this->description = $description->setParent($this);

        return $this;
    }

    /**
     * @param string $description
     * @return static
     */
    public function description(string $description): self
    {
        return $this->setDescription(new PlainText($description));
    }

    /**
     * @param string $url
     * @return static
     */
    public function url(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function validate(): void
    {
        if (empty($this->text)) {
            throw new Exception('Option element must contain a "text" element');
        }

        $this->text->validateWithLength(75, 1);

        if (!is_string($this->value)) {
            throw new Exception('Option element must have a "value" value');
        }

        Text::validateString($this->value, 75);

        $parent = $this->getParent();

        if (!empty($this->description)) {
            $this->description->validateWithLength(75, 1);
            if ($parent && !in_array($parent->getType(), [Type::CHECKBOXES, Type::RADIO_BUTTONS], true)) {
                throw new Exception('Option "description" can only be applied to checkbox and radio button groups.');
            }
        }

        if (!empty($this->url)) {
            Text::validateString($this->url, 3000);
            if ($parent && $parent->getType() !== Type::OVERFLOW_MENU) {
                throw new Exception('Option "url" can only be applied to overflow menus.');
            }
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [
            'text' => $this->text->toArray(),
            'value' => $this->value,
        ];

        if (!empty($this->description)) {
            $data['description'] = $this->description->toArray();
        }

        if (!empty($this->url)) {
            $data['url'] = $this->url;
        }

        return parent::toArray() + $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('text')) {
            $this->setText(PlainText::fromArray($data->useElement('text')));
        }

        if ($data->has('value')) {
            $this->value($data->useValue('value'));
        }

        if ($data->has('description')) {
            $this->setDescription(PlainText::fromArray($data->useElement('description')));
        }

        if ($data->has('url')) {
            $this->value($data->useValue('url'));
        }

        parent::hydrate($data);
    }
}
