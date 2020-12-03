<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Blocks;

use Jeremeamia\Slack\BlockKit\Element;
use Jeremeamia\Slack\BlockKit\HydrationData;

abstract class BlockElement extends Element
{
    /** @var string|null */
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
     * @return string|null
     */
    public function getBlockId(): ?string
    {
        return $this->blockId;
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

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('block_id')) {
            $this->blockId($data->useValue('block_id'));
        }

        parent::hydrate($data);
    }
}
