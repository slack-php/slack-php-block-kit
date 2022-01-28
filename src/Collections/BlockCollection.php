<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Collections;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Blocks\Section;

/**
 * @extends ComponentCollection<Block>
 */
class BlockCollection extends ComponentCollection
{
    protected static function createComponent(array $data): Block
    {
        return Block::fromArray($data);
    }

    /**
     * @param array<Block|self|string|null> $blocks
     */
    public function __construct(array $blocks = [])
    {
        $this->append(...$blocks);
    }

    public function append(Block|self|string|null ...$blocks): void
    {
        $this->add($blocks, false);
    }

    public function prepend(Block|self|string|null ...$blocks): void
    {
        $this->add($blocks, true);
    }

    protected function prepareItems(array $items): iterable
    {
        foreach ($items as $block) {
            if ($block instanceof Block) {
                yield $block;
            } elseif ($block instanceof self) {
                yield from $block;
            } elseif (is_string($block)) {
                yield new Section($block);
            }
        }
    }
}
