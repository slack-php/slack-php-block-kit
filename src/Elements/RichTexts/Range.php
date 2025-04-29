<?php

namespace SlackPhp\BlockKit\Elements\RichTexts;

enum Range: string
{
    case CHANNEL = 'channel';
    case EVERYONE = 'everyone';
    case HERE = 'here';

    public static function fromValue(self|string|null $value): ?self
    {
        return is_string($value) ? self::from($value) : $value;
    }
}
