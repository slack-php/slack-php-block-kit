<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Traits;

trait HasActionId
{
    public ?string $actionId;

    public function actionId(?string $actionId): self
    {
        $this->actionId = $actionId;

        return $this;
    }
}
