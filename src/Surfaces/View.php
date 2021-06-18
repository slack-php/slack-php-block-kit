<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\HydrationData;

use function base64_encode;
use function http_build_query;

/**
 * View represents the commonalities between the Modal and App Home surfaces.
 *
 * Modal and App Home surfaces are sometimes collectively called "views" in Slack documentation and APIs.
 */
abstract class View extends Surface
{
    /** @var string */
    private $callbackId;

    /** @var string */
    private $externalId;

    /** @var string */
    private $privateMetadata;

    /**
     * @param string $callbackId
     * @return static
     */
    public function callbackId(string $callbackId): self
    {
        $this->callbackId = $callbackId;

        return $this;
    }

    /**
     * @param string $externalId
     * @return static
     */
    public function externalId(string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * @param string $privateMetadata
     * @return static
     */
    public function privateMetadata(string $privateMetadata): self
    {
        $this->privateMetadata = $privateMetadata;

        return $this;
    }

    /**
     * Encodes the provided associative array of data into a string for `private_metadata`.
     *
     * Note: Can be decoded using `base64_decode()` and `parse_str()`.
     *
     * @param array $data
     * @return static
     */
    public function encodePrivateMetadata(array $data): self
    {
        return $this->privateMetadata(base64_encode(http_build_query($data)));
    }

    public function toArray(): array
    {
        $data = [];

        if (!empty($this->callbackId)) {
            $data['callback_id'] = $this->callbackId;
        }

        if (!empty($this->externalId)) {
            $data['external_id'] = $this->externalId;
        }

        if (!empty($this->privateMetadata)) {
            $data['private_metadata'] = $this->privateMetadata;
        }

        $data += parent::toArray();

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('callback_id')) {
            $this->callbackId($data->useValue('callback_id'));
        }

        if ($data->has('external_id')) {
            $this->externalId($data->useValue('external_id'));
        }

        if ($data->has('private_metadata')) {
            $this->privateMetadata($data->useValue('private_metadata'));
        }

        parent::hydrate($data);
    }
}
