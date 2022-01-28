<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Parts\{Confirm, PlainText};

class UserSelectMenu extends SelectMenu
{
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

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'initial_user' => $this->initialUser,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->initialUser($data->useValue('initial_user'));
        parent::hydrateFromArrayData($data);
    }
}
