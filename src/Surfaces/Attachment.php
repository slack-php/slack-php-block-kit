<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Collections\BlockCollection;
use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Hydration\OmitType;
use SlackPhp\BlockKit\Validation\{RequiresAllOf, UniqueIds, ValidCollection};

/**
 * Attachments are a surface that represent secondary content within a message, and can only exist within a message.
 *
 * Messages can add one or more attachments that have their own set of blocks.
 *
 * Attachments have other legacy attributes besides "color", but their use is discouraged. You can accomplish all of the
 * same things using blocks. If you want to set the legacy attributes, you can use `setExtra()`, inherited from Element.
 *
 * @see Component::extra()
 * @see https://api.slack.com/messaging/composing/layouts#attachments
 */
#[OmitType, RequiresAllOf('blocks')]
class Attachment extends Surface
{
    #[Property, ValidCollection(50), UniqueIds]
    public BlockCollection $blocks;

    #[Property]
    public ?string $color;

    /**
     * @param BlockCollection|array<Block|string>|null $blocks
     */
    public function __construct(BlockCollection|array|null $blocks = null, ?string $color = null)
    {
        parent::__construct($blocks);
        $this->color($color);
    }

    /**
     * Sets the hex color of the attachment. It Appears as a border along the left side.
     *
     * This makes sure the `#` is included in the color, in case you forget it.
     */
    public function color(?string $color): self
    {
        $this->color = $color ? '#' . ltrim($color, '#') : null;

        return $this;
    }
}
