<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Partials;

use Jeremeamia\Slack\BlockKit\{Element, Exception};

class Option extends Element
{
    /** @var PlainText */
    private $text;

    /** @var string */
    private $value;

    /** @var bool */
    private $isInitial = false;

    public function __construct(?string $text = null, string $value, bool $isInitial = false)
    {
        if ($text !== null) {
            $this->text($text);
        }

        $this->value($value);
        $this->isInitial = $isInitial;
    }

    /**
     * @param PlainText $text
     * @return self
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
     * @return bool
     */
    public function isInitial(): bool
    {
        return $this->isInitial;
    }

    public function validate(): void
    {
        if (empty($this->text)) {
            throw new Exception('Option element must contain a "text" element');
        }

        $this->text->validate();

        if (!is_string($this->value) || strlen($this->value) === 0) {
            throw new Exception('Option element must have a "value" value');
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return parent::toArray() + [
            'text' => $this->text->toArray(),
            'value' => $this->value,
        ];
    }
}
