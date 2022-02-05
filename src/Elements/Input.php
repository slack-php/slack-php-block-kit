<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Elements\Traits\HasActionId;
use SlackPhp\BlockKit\Property;

abstract class Input extends Element
{
    use HasActionId;

    #[Property('focus_on_load')]
    public ?bool $focusOnLoad;

    public function __construct(?string $actionId = null, ?bool $focusOnLoad = null)
    {
        parent::__construct();
        $this->actionId($actionId);
        $this->focusOnLoad($focusOnLoad);
    }

    public function focusOnLoad(?bool $focusOnLoad): static
    {
        $this->focusOnLoad = $focusOnLoad;

        return $this;
    }
}
