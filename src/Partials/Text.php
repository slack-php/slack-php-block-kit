<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Partials;

use SlackPhp\BlockKit\{Element, Exception, HydrationData};

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
        self::validateString($this->text);
    }

    /**
     * Validate the length of the text element.
     *
     * @param int|null $max Max length, or null if it doesn't have a max.
     * @param int $min Min length, defaults to 0.
     */
    public function validateWithLength(?int $max = null, int $min = 1): void
    {
        self::validateString($this->text, $max, $min);
    }

    /**
     * Validate string length for textual element properties.
     *
     * @param string $text String to validate.
     * @param int|null $max Max length, or null if it doesn't have a max.
     * @param int $min Min length, defaults to 0.
     */
    public static function validateString(?string $text, ?int $max = null, int $min = 1): void
    {
        if (!is_string($text)) {
            throw new Exception('Text element must have a "text" value');
        }

        if (mb_strlen($text, 'UTF-8') < $min) {
            throw new Exception('Text element must have a "text" value with a length of at least %d', [$min]);
        }

        if (is_int($max) && mb_strlen($text, 'UTF-8') > $max) {
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

    protected function hydrate(HydrationData $data): void
    {
        $this->text($data->useValue('text'));

        parent::hydrate($data);
    }
}
