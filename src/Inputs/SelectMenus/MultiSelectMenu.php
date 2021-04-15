<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Inputs\SelectMenus;

use SlackPhp\BlockKit\HydrationData;

abstract class MultiSelectMenu extends SelectMenu
{
    /** @var int|null */
    protected $maxSelectedItems;

    /**
     * @param int $maxSelectedItems
     * @return static
     */
    public function maxSelectedItems(int $maxSelectedItems): self
    {
        $this->maxSelectedItems = $maxSelectedItems;

        return $this;
    }

    /**
     * @param int $maxSelectedItems
     * @return static
     * @deprecated Inconsistent method name. Use MultiSelectMenu::maxSelectedItems() instead.
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

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('max_selected_items')) {
            $this->maxSelectedItems($data->useValue('max_selected_items'));
        }

        parent::hydrate($data);
    }
}
