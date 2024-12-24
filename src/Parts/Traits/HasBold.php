<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts\Traits;

use SlackPhp\BlockKit\Property;

trait HasBold
{
    #[Property]
    public ?bool $bold;

    public function bold(?bool $bold): self
    {
        $this->bold = $bold;

        return $this;
    }
}
