<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\HydrationData;

class File extends BlockElement
{
    /** @var string */
    private $externalId;

    /** @var string */
    private $source;

    /**
     * @param string|null $blockId
     * @param string|null $externalId
     * @param string $source
     */
    public function __construct(?string $blockId = null, ?string $externalId = null, string $source = 'remote')
    {
        parent::__construct($blockId);

        if (!empty($externalId)) {
            $this->externalId($externalId);
        }

        if (!empty($source)) {
            $this->source($source);
        }
    }

    public function externalId(string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function source(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function validate(): void
    {
        if (empty($this->externalId)) {
            throw new Exception('File must contain "external_id"');
        }

        if (empty($this->source)) {
            throw new Exception('File must contain "source"');
        }
    }

    public function toArray(): array
    {
        return parent::toArray() + [
            'external_id' => $this->externalId,
            'source' => $this->source,
        ];
    }

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('external_id')) {
            $this->externalId($data->useValue('external_id'));
        }

        if ($data->has('source')) {
            $this->externalId($data->useValue('source'));
        }

        parent::hydrate($data);
    }
}
