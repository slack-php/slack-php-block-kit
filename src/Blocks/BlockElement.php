<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Blocks;

use Jeremeamia\Slack\BlockKit\Element;
use Jeremeamia\Slack\BlockKit\Surfaces\AppSurface;

abstract class BlockElement extends Element
{
    /** @var string */
    private $blockId;

    /**
     * @param string|null $blockId
     */
    public function __construct(?string $blockId = null)
    {
        if (!empty($blockId)) {
            $this->blockId($blockId);
        }
    }

    /**
     * @param string $blockId
     * @return static
     */
    public function blockId(string $blockId): self
    {
        $this->blockId = $blockId;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->blockId)) {
            $data['block_id'] = $this->blockId;
        }

        return $data;
    }
}
