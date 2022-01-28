<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Collections\BlockCollection;
use SlackPhp\BlockKit\{Component, Kit};
use SlackPhp\BlockKit\Tools\HydrationData;

/**
 * A Slack app surface is something within a Slack app that renders blocks from the block kit (e.g., a Message).
 */
abstract class Surface extends Component
{
    protected const MAX_BLOCKS = 50;

    public BlockCollection $blocks;

    /**
     * @param BlockCollection|array<Block|string>|null $blocks
     */
    public function __construct(BlockCollection|array|null $blocks = null)
    {
        parent::__construct();
        $this->blocks = BlockCollection::wrap($blocks);
    }

    public function blocks(BlockCollection|Block|string|null ...$blocks): static
    {
        $this->blocks->append(...$blocks);

        return $this;
    }

    /**
     * @return Block[]
     */
    public function getBlocks(): array
    {
        return [...$this->blocks];
    }

    public function getPreviewLink(): string
    {
        return Kit::preview($this);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'blocks' => $this->blocks->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->blocks = BlockCollection::fromArray($data->useComponents('blocks'));
        parent::hydrateFromArrayData($data);
    }
}
