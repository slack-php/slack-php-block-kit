<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Surfaces;

use Jeremeamia\Slack\BlockKit\Blocks\{
    Actions,
    BlockElement,
    Context,
    Divider,
    Image,
    Section,
};
use Jeremeamia\Slack\BlockKit\Blocks\Virtual\{VirtualBlock, TwoColumnTable};
use Jeremeamia\Slack\BlockKit\{Exception, Element, Type};

/**
 * A Slack app surface is something within a Slack app that renders blocks from the block kit (e.g., a Message).
 */
abstract class Surface extends Element
{
    private const MAX_BLOCKS = 50;

    /** @var BlockElement[] */
    private $blocks = [];

    /**
     * @param BlockElement $block
     * @return static
     */
    public function add(BlockElement $block): self
    {
        if (!in_array($block->getType(), Type::SURFACE_BLOCKS[$this->getType()], true)) {
            throw new Exception(
                'Block type %s is not supported for surface type %s',
                [$block->getType(), $this->getType()]
            );
        }

        $this->blocks[] = $block->setParent($this);

        return $this;
    }

    /**
     * @return BlockElement[]
     */
    public function getBlocks(): array
    {
        $blocks = [];
        foreach ($this->blocks as $block) {
            if ($block instanceof VirtualBlock) {
                foreach ($block->getBlocks() as $subBlock) {
                    $blocks[] = $subBlock;
                }
            } else {
                $blocks[] = $block;
            }
        }

        return $blocks;
    }

    /**
     * @param string|null $blockId
     * @return Actions
     */
    public function newActions(?string $blockId = null): Actions
    {
        $block = new Actions($blockId);
        $this->add($block);

        return $block;
    }

    /**
     * @param string|null $blockId
     * @return Context
     */
    public function newContext(?string $blockId = null): Context
    {
        $block = new Context($blockId);
        $this->add($block);

        return $block;
    }

    /**
     * @param string|null $blockId
     * @return Image
     */
    public function newImage(?string $blockId = null): Image
    {
        $block = new Image($blockId);
        $this->add($block);

        return $block;
    }

    /**
     * @param string|null $blockId
     * @return Section
     */
    public function newSection(?string $blockId = null): Section
    {
        $block = new Section($blockId);
        $this->add($block);

        return $block;
    }

    /**
     * @param string|null $blockId
     * @return TwoColumnTable
     */
    public function newTwoColumnTable(?string $blockId = null): TwoColumnTable
    {
        $block = new TwoColumnTable($blockId);
        $this->add($block);

        return $block;
    }

    /**
     * @param string|null $blockId
     * @return static
     */
    public function divider(?string $blockId = null): self
    {
        return $this->add(new Divider($blockId));
    }

    /**
     * @param string $text
     * @param string|null $blockId
     * @return static
     */
    public function text(string $text, ?string $blockId = null): self
    {
        $block = new Section($blockId, $text);

        return $this->add($block);
    }

    public function validate(): void
    {
        $blocks = $this->getBlocks();

        if (empty($blocks)) {
            throw new Exception('A surface must contain at least one block');
        }

        if (count($blocks) >= self::MAX_BLOCKS) {
            throw new Exception('A surface cannot have more than %d blocks', [self::MAX_BLOCKS]);
        }

        foreach ($blocks as $block) {
            $block->validate();
        }
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        $data['blocks'] = [];
        foreach ($this->getBlocks() as $block) {
            $data['blocks'][] = $block->toArray();
        }

        return $data;
    }
}
