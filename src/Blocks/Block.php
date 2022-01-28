<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\{Tools\HydrationData, Tools\Validator};
use SlackPhp\BlockKit\Enums\Type;
use SlackPhp\BlockKit\Exception;

abstract class Block extends Component
{
    public function __construct(public ?string $blockId = null)
    {
        parent::__construct();
        $this->blockId($blockId);
    }

    public function blockId(?string $blockId): static
    {
        $this->blockId = $blockId;

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->validateString('block_id', 255);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'block_id' => $this->blockId,
        ];
    }

    public static function fromArray(?array $data): ?static
    {
        $type = Type::from($data['type'] ?? throw new Exception('Block components must have a type'));

        // Since the "image" type is used in Slack as both a Block and Element type, we have to map the block-level
        // image to a different, unique type in order for `Block::fromArray` to resolve to the BlockImage class.
        // The reverse logic is in `Type::toSlackValue`
        if ($type === Type::IMAGE) {
            $data['type'] = Type::BLOCK_IMAGE->value;
        }

        return parent::fromArray($data);
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->blockId($data->useValue('block_id'));
        parent::hydrateFromArrayData($data);
    }
}
