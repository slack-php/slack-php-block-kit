<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\HydrationData;
use Jeremeamia\Slack\BlockKit\Inputs\{HasPlaceholder, HasConfirm, InputElement};
use Jeremeamia\Slack\BlockKit\Partials\{Confirm, PlainText};

abstract class SelectMenu extends InputElement
{
    use HasConfirm;
    use HasPlaceholder;

    public function validate(): void
    {
        if (empty($this->placeholder)) {
            throw new Exception('Select menus must contain a "placeholder"');
        }

        $this->placeholder->validate();

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

        $data['placeholder'] = $this->placeholder->toArray();

        if (!empty($this->confirm)) {
            $data['confirm'] = $this->confirm->toArray();
        }

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('placeholder')) {
            $this->setPlaceholder(PlainText::fromArray($data->useElement('placeholder')));
        }

        if ($data->has('confirm')) {
            $this->setConfirm(Confirm::fromArray($data->useElement('confirm')));
        }

        parent::hydrate($data);
    }
}
