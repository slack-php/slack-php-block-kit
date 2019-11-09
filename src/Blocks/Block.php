<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Blocks;

use Jeremeamia\Slack\BlockKit\Element;

abstract class Block extends Element
{
    /** @var string */
    private $blockId;

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
