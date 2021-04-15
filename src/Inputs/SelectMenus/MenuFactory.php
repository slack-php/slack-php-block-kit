<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Inputs\SelectMenus;

abstract class MenuFactory
{
    /** @var string|null */
    protected $actionId;

    /** @var callable|null */
    protected $parentCallback;

    public function __construct(?string $actionId = null, ?callable $parentCallback = null)
    {
        $this->actionId = $actionId;
        $this->parentCallback = $parentCallback;
    }

    protected function create(string $class)
    {
        $menu = new $class($this->actionId);

        if ($this->parentCallback) {
            ($this->parentCallback)($menu);
        }

        return $menu;
    }
}
