<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

enum ConversationType: string
{
    case IM = 'im';
    case MPIM = 'mpim';
    case PRIVATE = 'private';
    case PUBLIC = 'public';

    public static function fromValue(self|string|null $value): ?self
    {
        return is_string($value) ? self::from($value) : $value;
    }

    /**
     * @param self|string|null ...$values
     * @return array<self>
     */
    public static function enumSet(self|string|null ...$values): array
    {
        $enums = [];
        foreach (array_filter(array_map(self::fromValue(...), $values)) as $enum) {
            foreach ($enums as $existingEnum) {
                if ($enum === $existingEnum) {
                    continue(2);
                }
            }

            $enums[] = $enum;
        }

        return $enums;
    }
}
