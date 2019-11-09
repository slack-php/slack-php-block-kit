<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Surfaces;

use Jeremeamia\Slack\BlockKit\Blocks\{Block, Context, Divider, Image, Section};
use Jeremeamia\Slack\BlockKit\{Exception, Element, Type};

/**
 * A Slack app surface is something within a Slack app that renders blocks from the block kit (e.g., a Message).
 *
 * There are currently three kinds of app surfaces: Message, Model, AppHome.
 *
 * @method Context context(string $blockId = '') Create a new Context block.
 * @method Divider divider(string $blockId = '') Create a new Divider block.
 * @method Image image(string $blockId = '') Create a new Image block.
 * @method Section section(string $blockId = '') Create a new Section block.
 */
abstract class Surface extends Element
{
    /** @var Block[] */
    private $blocks = [];

    /**
     * @param Block $block
     * @return static
     */
    public function add(Block $block): self
    {
        $this->blocks[] = $block->setParent($this);

        return $this;
    }

    /**
     * @return Block[]
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    public function __call($type, $args)
    {
        $class = Type::mapToClass($type);
        if (!is_a($class, Block::class, true)) {
            throw new Exception("Invalid block type: {$type}");
        }

        /** @var Block $block */
        $block = new $class();
        if (!empty($args[0]) && is_string($args[0])) {
            $block->blockId($args[0]);
        }

        $this->add($block);

        return $block;
    }

    public function validate(): void
    {
        if (empty($this->blocks)) {
            throw new Exception("A {$this->getType()} surface must contain at least one block");
        }

        foreach ($this->blocks as $block) {
            $block->validate();
        }
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        $data['blocks'] = [];
        foreach ($this->blocks as $block) {
            var_dump($block);
            $data['blocks'][] = $block->toArray();
        }

        return $data;
    }
}
