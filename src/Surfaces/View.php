<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Collections\BlockCollection;
use SlackPhp\BlockKit\Tools\{HydrationData, PrivateMetadata, Validator};

/**
 * View represents the commonalities between the Modal and App Home surfaces.
 *
 * Modal and App Home surfaces are sometimes collectively called "views" in Slack documentation and APIs.
 */
abstract class View extends Surface
{
    use HasIdAndMetadata;

    protected const MAX_BLOCKS = 100;

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

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireAllOf('blocks')
            ->validateCollection('blocks', max: static::MAX_BLOCKS, min: 1)
            ->validateString('callback_id', 255)
            ->validateString('private_metadata', 3000);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'callback_id' => $this->callbackId,
            'external_id' => $this->externalId,
            'private_metadata' => $this->privateMetadata,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->callbackId($data->useValue('callback_id'));
        $this->externalId($data->useValue('external_id'));
        $this->privateMetadata($data->useValue('private_metadata'));
        parent::hydrateFromArrayData($data);
    }
}
