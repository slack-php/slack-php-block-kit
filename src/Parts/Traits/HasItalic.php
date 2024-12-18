<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts\Traits;

use SlackPhp\BlockKit\Property;

trait HasItalic
{
    #[Property]
    public ?bool $italic;

    public function italic(?bool $italic): self
    {
        $this->italic = $italic;

        return $this;
    }
}
