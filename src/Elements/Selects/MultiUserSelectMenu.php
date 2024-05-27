<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Parts\{Confirm, PlainText};
use SlackPhp\BlockKit\Validation\{RequiresAllOf, ValidCollection};

#[RequiresAllOf('placeholder')]
class MultiUserSelectMenu extends MultiSelectMenu
{
    /** @var string[]|null */
    #[Property('initial_users'), ValidCollection]
    public ?array $initialUsers;

    /**
     * @param string[]|null $initialUsers
     */
    public function __construct(
        ?string $actionId = null,
        PlainText|string|null $placeholder = null,
        ?array $initialUsers = null,
        ?int $maxSelectedItems = null,
        ?Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ) {
        parent::__construct($actionId, $placeholder, $maxSelectedItems, $confirm, $focusOnLoad);
        $this->initialUsers($initialUsers);
    }

    /**
     * @param string[]|null $initialUsers
     */
    public function initialUsers(?array $initialUsers): self
    {
        $this->initialUsers = $initialUsers;

        return $this;
    }
}
