<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Inputs\HasPlaceholder;
use Jeremeamia\Slack\BlockKit\Inputs\HasConfirm;
use Jeremeamia\Slack\BlockKit\Inputs\InputElement;

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
}
