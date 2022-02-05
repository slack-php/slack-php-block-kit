<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\PrivateMetadata;
use SlackPhp\BlockKit\Tools\Validation\ValidString;

trait HasIdAndMetadata
{
    #[Property('callback_id'), ValidString(255)]
    public ?string $callbackId;

    #[Property('private_metadata'), ValidString(3000)]
    public ?string $privateMetadata;

    public function callbackId(?string $callbackId): static
    {
        $this->callbackId = $callbackId;

        return $this;
    }

    /**
     * @param PrivateMetadata|array<string, string|int|float|bool>|string|null $privateMetadata
     */
    public function privateMetadata(PrivateMetadata|array|string|null $privateMetadata): static
    {
        if (is_array($privateMetadata)) {
            $privateMetadata = new PrivateMetadata($privateMetadata);
        }

        if ($privateMetadata instanceof PrivateMetadata) {
            $privateMetadata = (string) $privateMetadata;
        }

        $this->privateMetadata = $privateMetadata ?: null;

        return $this;
    }
}
