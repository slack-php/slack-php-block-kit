<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Selects;

use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Tools\Validator;

class MultiUserSelectMenu extends MultiSelectMenu
{
    /** @var string[]|null */
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

    protected function validateInternalData(Validator $validator): void
    {
        $validator->validateCollection('initial_users', $this->maxSelectedItems ?? 0);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'initial_users' => $this->initialUsers,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->initialUsers($data->useArray('initial_users'));
        parent::hydrateFromArrayData($data);
    }
}
