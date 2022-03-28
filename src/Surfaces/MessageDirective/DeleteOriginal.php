<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces\MessageDirective;

use SlackPhp\BlockKit\Exception;

enum DeleteOriginal
{
    case DELETE_ORIGINAL;
    case DONT_DELETE_ORIGINAL;

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return match ($this) {
            self::DELETE_ORIGINAL => ['delete_original' => 'true'],
            self::DONT_DELETE_ORIGINAL => ['delete_original' => 'false'],
        };
    }

    /**
     * @param self|array<string, string>|bool|null $data
     * @return static|null
     */
    public static function fromValue(self|array|bool|null $data): ?self
    {
        if ($data instanceof self) {
            return $data;
        }

        if (is_bool($data)) {
            return $data ? self::DELETE_ORIGINAL : self::DONT_DELETE_ORIGINAL;
        }

        if (is_array($data)) {
            $data = array_filter($data);
            return match ($data) {
                ['delete_original' => 'true'] => self::DELETE_ORIGINAL,
                ['delete_original' => 'false'] => self::DONT_DELETE_ORIGINAL,
                [] => null,
                default => throw new Exception('Invalid Delete Original enum encountered: %s', [json_encode($data)]),
            };
        }

        return null;
    }
}
