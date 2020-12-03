<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Blocks\Virtual;

use Jeremeamia\Slack\BlockKit\Blocks\BlockElement;
use Jeremeamia\Slack\BlockKit\HydrationData;
use Jeremeamia\Slack\BlockKit\HydrationException;

/**
 * An encapsulation of multiple blocks acting as one virtual element.
 */
abstract class VirtualBlock extends BlockElement
{
    /** @var int */
    private $index = 1;

    /** @var BlockElement[]\array */
    private $blocks = [];

    /**
     * @param BlockElement $block
     * @return static
     */
    protected function appendBlock(BlockElement $block): self
    {
        if ($this->getParent() !== null) {
            $block->setParent($this->getParent());
        }

        $this->blocks[] = $this->assignBlockId($block);

        return $this;
    }

    protected function prependBlock(BlockElement $block): self
    {
        if ($this->getParent() !== null) {
            $block->setParent($this->getParent());
        }

        $this->blocks = array_merge(
            [$this->assignBlockId($block, 1)],
            array_map(function (BlockElement $block) {
                return $this->assignBlockId($block);
            }, $this->blocks)
        );

        return $this;
    }

    private function assignBlockId(BlockElement $block, ?int $index = null): BlockElement
    {
        $multiBlockId = $this->getBlockId();
        if ($multiBlockId !== null) {
            $this->index = $index ?? $this->index;
            $block->blockId("{$this->getBlockId()}.{$this->index}");
            $this->index++;
        }

        return $block;
    }

    /**
     * @return BlockElement[]
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    public function validate(): void
    {
        foreach ($this->blocks as $block) {
            $block->validate();
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [];
        foreach ($this->blocks as $block) {
            $data[] = $block->toArray();
        }

        return $data;
    }

    /**
     * Hydrating virtual blocks cannot be done.
     *
     * Virtual Blocks are a write-only construct. They won't come up during a regular surface hydration. This exception
     * will only occur if someone calls `fromArray` manually on a virtual block class.
     *
     * @param HydrationData $data
     */
    protected function hydrate(HydrationData $data): void
    {
        throw new HydrationException('Cannot hydrate virtual blocks; they have no distinguishable representation');
    }
}
