<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Tools\PrivateMetadata;

trait HasIdAndMetadata
{
    public ?string $callbackId;
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
