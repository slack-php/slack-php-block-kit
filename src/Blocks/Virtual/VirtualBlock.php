<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks\Virtual;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Collections\BlockCollection;
use Traversable;

/**
 * An encapsulation of multiple blocks acting as one virtual block.
 */
abstract class VirtualBlock extends BlockCollection
{
    public ?string $blockId = null;

    public function blockId(?string $blockId): static
    {
        $this->blockId = $blockId;

        return $this;
    }

    public function getIterator(): Traversable
    {
        $blocks = parent::getIterator();
        if ($this->blockId === null) {
            yield from $blocks;
            return;
        }

        $index = 1;
        /** @var Block $block */
        foreach ($blocks as $block) {
            yield $block->blockId("{$this->blockId}.{$index}");
            $index++;
        }
    }
}
