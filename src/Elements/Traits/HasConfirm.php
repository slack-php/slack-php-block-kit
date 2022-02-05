<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\Traits;

use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Property;

trait HasConfirm
{
    #[Property]
    public ?Confirm $confirm;

    public function confirm(?Confirm $confirm): self
    {
        $this->confirm = $confirm;

        return $this;
    }
}
