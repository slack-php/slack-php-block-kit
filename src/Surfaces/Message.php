<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Surfaces;

class Message extends AppSurface
{
    private const EPHEMERAL = 'ephemeral';
    private const IN_CHANNEL = 'in_channel';

    /** @var string */
    private $responseType = self::EPHEMERAL;

    public function inChannel(bool $inChannel): self
    {
        $this->responseType = $inChannel ? self::IN_CHANNEL : self::EPHEMERAL;

        return $this;
    }

    public function toArray(): array
    {
        return ['response_type' => $this->responseType] + parent::toArray();
    }
}
