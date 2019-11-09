<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Surfaces;

use Jeremeamia\Slack\BlockKit\Blocks\{BlockElement, Context, Divider, Image, Section};
use Jeremeamia\Slack\BlockKit\{Exception, Element};

/**
 * A Slack app surface is something within a Slack app that renders blocks from the block kit (e.g., a Message).
 *
 * There are currently three kinds of app surfaces: Message, Model, AppHome.
 */
abstract class AppSurface extends Element
{
    /** @var BlockElement[] */
    private $blocks = [];

    /**
     * @param BlockElement $block
     * @return static
     */
    public function add(BlockElement $block): self
    {
        $this->blocks[] = $block->setParent($this);

        return $this;
    }

    /**
     * @return BlockElement[]
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    public function newContext(?string $blockId = null): Context
    {
        $block = new Context($blockId);
        $this->add($block);

        return $block;
    }

    public function newImage(?string $blockId = null): Image
    {
        $block = new Image($blockId);
        $this->add($block);

        return $block;
    }

    public function newSection(?string $blockId = null): Section
    {
        $block = new Section($blockId);
        $this->add($block);

        return $block;
    }

    public function divider(?string $blockId = null): self
    {
        return $this->add(new Divider($blockId));
    }

    public function text(string $text, ?string $blockId = null): self
    {
        $block = new Section($blockId, $text);

        return $this->add($block);
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
