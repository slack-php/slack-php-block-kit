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
        if (empty($this->text)) {
            throw new Exception('Text component must have a "text" value');
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
