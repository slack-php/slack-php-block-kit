<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces\MessageDirective;

use SlackPhp\BlockKit\Exception;

enum ResponseType
{
    case EPHEMERAL;
    case IN_CHANNEL;

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return match ($this) {
            self::EPHEMERAL => ['response_type' => 'ephemeral'],
            self::IN_CHANNEL => ['response_type' => 'in_channel'],
        };
    }

    /**
     * @param self|array<string, string>|null $data
     * @return static|null
     */
    public static function fromValue(self|array|null $data): ?self
    {
        if ($data instanceof self) {
            return $data;
        }

        if (is_array($data)) {
            $data = array_filter($data);
            return match ($data) {
                ['response_type' => 'ephemeral'] => self::EPHEMERAL,
                ['response_type' => 'in_channel'] => self::IN_CHANNEL,
                [] => null,
                default => throw new Exception('Invalid Response Type enum encountered: %s', [json_encode($data)]),
            };
        }

        return null;
    }
}
