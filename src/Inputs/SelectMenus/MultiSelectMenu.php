<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

abstract class MultiSelectMenu extends SelectMenu
{
    /** @var int|null */
    protected $maxSelectedItems;

    /**
     * @param int $maxSelectedItems
     * @return static
     */
    public function setMaxSelectedItems(int $maxSelectedItems): self
    {
        $this->maxSelectedItems = $maxSelectedItems;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->maxSelectedItems)) {
            $data['max_selected_items'] = $this->maxSelectedItems;
        }

        return $data;
    }
}
