<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Traits;

use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\ValidString;

trait HasActionId
{
    #[Property('action_id'), ValidString(255)]
    public ?string $actionId;

    public function actionId(?string $actionId): self
    {
        $this->actionId = $actionId;

        return $this;
    }
}
