<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Inputs\SelectMenus;

use SlackPhp\BlockKit\HydrationData;

class UserSelectMenu extends SelectMenu
{
    /** @var string */
    private $initialUser;

    /**
     * @param string $initialUser
     * @return static
     */
    public function initialUser(string $initialUser): self
    {
        $this->initialUser = $initialUser;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->initialUser)) {
            $data['initial_user'] = $this->initialUser;
        }

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('initial_user')) {
            $this->initialUser($data->useValue('initial_user'));
        }

        parent::hydrate($data);
    }
}
