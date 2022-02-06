<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Exception;

enum MessageDirective
{
    case EPHEMERAL;
    case IN_CHANNEL;
    case REPLACE_ORIGINAL;
    case DELETE_ORIGINAL;

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return match ($this) {
            self::EPHEMERAL => ['response_type' => 'ephemeral'],
            self::IN_CHANNEL => ['response_type' => 'in_channel'],
            self::REPLACE_ORIGINAL => ['replace_original' => 'true'],
            self::DELETE_ORIGINAL => ['delete_original' => 'true'],
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
                ['replace_original' => 'true'] => self::REPLACE_ORIGINAL,
                ['delete_original' => 'true'] => self::DELETE_ORIGINAL,
                [] => null,
                default => throw new Exception('Invalid MessageDirective enum encountered: %s', [json_encode($data)]),
            };
        }

        return null;
    }
}
