<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Partials;

use Jeremeamia\Slack\BlockKit\{Element, Exception};

abstract class Text extends Element
{
    /** @var string */
    private $text;

    /**
     * @param string $text
     * @return static
     */
    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function validate(): void
    {
        $this->validateWithLength();
    }

    /**
     * Validate the length of the text element.
     *
     * @param int|null $max Max length, or null if it doesn't have a max.
     * @param int $min Min length, defaults to 0.
     */
    public function validateWithLength(?int $max = null, int $min = 0): void
    {
        if (!is_string($this->text)) {
            throw new Exception('Text element must have a "text" value');
        }

        if (strlen($this->text) < $min) {
            throw new Exception('Text element must have a "text" value with a length of at least %d', [$min]);
        }

        if (is_int($max) && strlen($this->text) > $max) {
            throw new Exception('Text element must have a "text" value with a length of at most %d', [$max]);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return parent::toArray() + ['text' => $this->text];
    }
}
