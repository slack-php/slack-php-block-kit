<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Partials\PlainText;

class TextInput extends InputElement
{

    /** @var PlainText */
    private $placeholder = '';

    /** @var string */
    private $initialValue = '';

    /** @var bool */
    private $multiline = false;

    /** @var int */
    private $minLength;

    /** @var int */
    private $maxLength;



    public function setPlaceholder(PlainText $placeholder): self
    {
        $this->placeholder = $placeholder->setParent($this);

        return $this;
    }

    public function placeholder(string $placeholder): self
    {
        return $this->setPlaceholder(new PlainText($placeholder));
    }

    public function initialValue(string $text): self
    {
        $this->initialValue = $text;

        return $this;
    }

    public function multiline(bool $flag): self
    {
        $this->multiline = $flag;

        return $this;
    }

    public function minLength(int $length): self
    {
        $this->minLength = $length;

        return $this;
    }

    public function maxLength(int $length): self
    {
        $this->maxLength = $length;

        return $this;
    }

    public function validate(): void
    {
        if (!empty($this->placeholder)) {
            $this->placeholder->validate();
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->placeholder)) {
            $data['placeholder'] = $this->placeholder->toArray();
        }

        if (!empty($this->initialValue)) {
            $data['initial_value'] = $this->initialValue;
        }

        if (!empty($this->multiline)) {
            $data['multiline'] = $this->multiline;
        }

        if (!empty($this->minLength)) {
            $data['min_length'] = $this->minLength;
        }

        if (!empty($this->maxLength)) {
            $data['max_length'] = $this->maxLength;
        }

        return $data;
    }
}
