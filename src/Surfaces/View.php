<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Collections\BlockCollection;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\PrivateMetadata;

/**
 * View represents the commonalities between the Modal and App Home surfaces.
 *
 * Modal and App Home surfaces are sometimes collectively called "views" in Slack documentation and APIs.
 */
abstract class View extends Surface
{
    use HasIdAndMetadata;

    #[Property('external_id')]
    public ?string $externalId;

    /**
     * @param BlockCollection|array<Block|string>|null $blocks
     */
    public function __construct(
        BlockCollection|array|null $blocks = null,
        ?string $callbackId = null,
        ?string $externalId = null,
        PrivateMetadata|array|string|null $privateMetadata = null,
    ) {
        parent::__construct($blocks);
        $this->callbackId($callbackId);
        $this->externalId($externalId);
        $this->privateMetadata($privateMetadata);
    }

    public function externalId(?string $externalId): static
    {
        $this->externalId = $externalId;

        return $this;
    }
}
