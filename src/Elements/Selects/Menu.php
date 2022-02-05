<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Elements\Input;
use SlackPhp\BlockKit\Elements\Traits\{HasConfirm, HasPlaceholder};
use SlackPhp\BlockKit\Parts\{Confirm, PlainText};

abstract class Menu extends Input
{
    use HasConfirm;
    use HasPlaceholder;

    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $focusOnLoad);
        $this->placeholder($placeholder);
        $this->confirm($confirm);
    }
}
