<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts\Traits;

use SlackPhp\BlockKit\Property;

trait HasStrike
{
    #[Property]
    public ?bool $strike;

    public function strike(?bool $strike): self
    {
        $this->strike = $strike;

        return $this;
    }
}
