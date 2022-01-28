<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\{Tools\HydrationData, Tools\Validator};

class File extends Block
{
    public function __construct(
        public ?string $externalId = null,
        public ?string $source = 'remote',
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

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireAllOf('external_id', 'source');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'external_id' => $this->externalId,
            'source' => $this->source,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->externalId($data->useValue('external_id'));
        $this->source($data->useValue('source'));
        parent::hydrateFromArrayData($data);
    }
}
