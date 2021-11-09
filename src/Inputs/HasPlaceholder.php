<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Inputs;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Partials\PlainText;

trait HasPlaceholder
{
    /** @var PlainText */
    private $placeholder;

    /**
     * @param PlainText $placeholder
     * @return static
     */
    public function setPlaceholder(PlainText $placeholder): self
    {
        $this->placeholder = $placeholder->setParent($this);

        return $this;
    }

    /**
     * @param string $placeholder
     * @return static
     */
    public function placeholder(string $placeholder): self
    {
        if (mb_strlen($placeholder, 'UTF-8') > 150) {
            throw new Exception('Placeholder cannot exceed 150 characters');
        }

        return $this->setPlaceholder(new PlainText($placeholder));
    }
}
