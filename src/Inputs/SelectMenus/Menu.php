<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

use Jeremeamia\Slack\BlockKit\Partials\PlainText;
use Jeremeamia\Slack\BlockKit\Inputs\HasConfirm;
use Jeremeamia\Slack\BlockKit\Inputs\InputElement;

abstract class Menu extends InputElement
{
    use HasConfirm;

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
        return $this->setPlaceholder(new PlainText($placeholder));
    }

    public function validate(): void
    {
        if (!empty($this->placeholder)) {
            $this->placeholder->validate();
        }

        if (!empty($this->confirm)) {
            $this->confirm->validate();
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

        if (!empty($this->confirm)) {
            $data['confirm'] = $this->confirm->toArray();
        }

        return $data;
    }
}
