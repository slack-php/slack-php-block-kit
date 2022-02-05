<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Validation\ValidString;
use SlackPhp\BlockKit\Type;

abstract class Block extends Component
{
    #[Property('block_id'), ValidString(255)]
    public ?string $blockId;

    public function __construct(?string $blockId = null)
    {
        parent::__construct();
        $this->blockId($blockId);
    }

    public function blockId(?string $blockId): static
    {
        $this->blockId = $blockId;

        return $this;
    }

    public static function fromArray(?array $data): ?static
    {
        $type = Type::from($data['type'] ?? throw new Exception('Block components must have a type'));

        // Since the "image" type is used in Slack as both a Block and Element type, we have to map the block-level
        // image to a different, unique type in order for `Block::fromArray` to resolve to the BlockImage class.
        // The reverse logic is handled by an `AliasType` attribute.
        if ($type === Type::IMAGE) {
            $data['type'] = Type::BLOCK_IMAGE->value;
        }

        return parent::fromArray($data);
    }
}
