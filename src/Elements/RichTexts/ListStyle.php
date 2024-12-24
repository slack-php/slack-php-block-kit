<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

enum ListStyle: string
{
    case BULLET = 'bullet';
    case ORDERED = 'ordered';

    public static function fromValue(self|string|null $value): ?self
    {
        return is_string($value) ? self::from($value) : $value;
    }
}
