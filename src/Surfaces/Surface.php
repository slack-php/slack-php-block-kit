<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Blocks\{Actions, BlockElement, Context, Divider, Header, Image, Input, Section};
use SlackPhp\BlockKit\Blocks\Virtual\{VirtualBlock, TwoColumnTable};
use SlackPhp\BlockKit\{
    Exception,
    Element,
    HydrationData,
    Type,
};

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
     * @param iterable|BlockElement[] $blocks
     * @return static
     */
    public function blocks(iterable $blocks): self
    {
        foreach ($blocks as $block) {
            $this->add($block);
        }

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
     * @return Header
     */
    public function newHeader(?string $blockId = null): Header
    {
        $block = new Header($blockId);
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

    public function newInput(?string $blockId = null): Input
    {
        $block = new Input($blockId);
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

    /**
     * @param string $text
     * @param string|null $blockId
     * @return static
     */
    public function header(string $text, ?string $blockId = null): self
    {
        $block = new Header($blockId, $text);

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

        $blolckIds = [];
        foreach ($blocks as $block) {
            $block->validate();
            if (! is_null($block->getBlockId())) {
                $blolckIds[] = $block->getBlockId();
            }
        }

        $blockIdArrayCount = array_count_values($blolckIds);
        if (count($blockIdArrayCount) > 0) {
            $duplicateBlockIds = [];
            foreach ($blockIdArrayCount as $key => $value) {
                if ((int)$value > 1) {
                    $duplicateBlockIds[] = $key;
                }
            }

            if (count($duplicateBlockIds) > 0) {
                throw new Exception(
                    'The following block_ids are duplicated : ' . implode(', ', $duplicateBlockIds) . ' ]'
                );
            }
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

    protected function hydrate(HydrationData $data): void
    {
        foreach ($data->useElements('blocks') as $block) {
            $this->add(BlockElement::fromArray($block));
        }

        parent::hydrate($data);
    }
}
