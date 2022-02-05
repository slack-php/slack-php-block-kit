<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Parts\{Confirm, PlainText};
use SlackPhp\BlockKit\Tools\Validation\RequiresAllOf;

#[RequiresAllOf('placeholder')]
class UserSelectMenu extends SelectMenu
{
    #[Property('initial_user')]
    public ?string $initialUser;

    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        ?string $initialUser = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $placeholder, $confirm, $focusOnLoad);
        $this->initialUser($initialUser);
    }

    public function initialUser(?string $initialUser): self
    {
        $this->initialUser = $initialUser;

        return $this;
    }
}
