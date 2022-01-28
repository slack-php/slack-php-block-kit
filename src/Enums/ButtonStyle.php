<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Enums;

enum ButtonStyle: string
{
    case DANGER = 'danger';
    case PRIMARY = 'primary';

    public static function fromValue(self|string|null $value): ?self
    {
        return $value instanceof self ? $value : ($value ? self::from($value) : null);
    }
}
