<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces\MessageDirective;

use SlackPhp\BlockKit\Exception;

enum ReplaceOriginal
{
    case REPLACE_ORIGINAL;
    case DONT_REPLACE_ORIGINAL;

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return match ($this) {
            self::REPLACE_ORIGINAL => ['replace_original' => 'true'],
            self::DONT_REPLACE_ORIGINAL => ['replace_original' => 'false'],
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
            return $data ? self::REPLACE_ORIGINAL : self::DONT_REPLACE_ORIGINAL;
        }

        if (is_array($data)) {
            $data = array_filter($data);
            return match ($data) {
                ['replace_original' => 'true'] => self::REPLACE_ORIGINAL,
                ['replace_original' => 'false'] => self::DONT_REPLACE_ORIGINAL,
                [] => null,
                default => throw new Exception('Invalid Replace Original enum encountered: %s', [json_encode($data)]),
            };
        }

        return null;
    }
}
