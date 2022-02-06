<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Validation\ValidString;

abstract class Block extends Component
{
    #[Property('block_id'), ValidString(255)]
    public ?string $blockId;

    public function __construct(?string $blockId = null)
    {
        parent::__construct();
        $this->blockId($blockId);
    }

    public function blockId(?string $blockId): static
    {
        $this->blockId = $blockId;

        return $this;
    }
}
