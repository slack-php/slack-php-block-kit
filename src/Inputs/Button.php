<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Partials\PlainText;

class Button extends InputElement
{
    /** @var PlainText */
    private $text;

    /** @var string */
    private $value;

    public function setText(PlainText $text): self
    {
        $this->text = $text->setParent($this);

        return $this;
    }

    public function text(string $text): self
    {
        return $this->setText(new PlainText($text));
    }

    public function value(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function validate(): void
    {
        if (empty($this->text)) {
            throw new Exception('Button must contain "text"');
        }

        if (empty($this->value)) {
            throw new Exception('Image must contain "value"');
        }

        if (!empty($this->text)) {
            $this->text->validate();
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['text'] = $this->text->toArray();
        $data['value'] = $this->value;

        return $data;
    }
}
