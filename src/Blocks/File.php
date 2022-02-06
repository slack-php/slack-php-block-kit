<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;

#[RequiresAllOf('external_id', 'source')]
class File extends Block
{
    public function __construct(
        #[Property('external_id')] public ?string $externalId = null,
        #[Property] public ?string $source = 'remote',
        ?string $blockId = null,
    ) {
        parent::__construct($blockId);
        $this->externalId($externalId);
        $this->source($source);
    }

    public function externalId(?string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function source(?string $source): self
    {
        $this->source = $source;

        return $this;
    }
}
