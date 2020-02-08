<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Partials\PlainText;

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
        if (strlen($placeholder) > 150) {
            throw new Exception('Placeholder cannot exceed 150 characters');
        }

        return $this->setPlaceholder(new PlainText($placeholder));
    }
}
