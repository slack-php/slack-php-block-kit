<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

enum OptionType
{
    case SELECT_MENU;
    case RADIO_GROUP;
    case CHECKBOX_GROUP;
    case OVERFLOW_MENU;

    /**
     * @return array<string>
     */
    public function fieldsToPrevent(): array
    {
        return match ($this) {
            self::RADIO_GROUP, self::CHECKBOX_GROUP => ['url'],
            self::OVERFLOW_MENU => ['description'],
            default => ['description', 'url'],
        };
    }

    public function allowsMarkdown(): bool
    {
        return match ($this) {
            self::RADIO_GROUP, self::CHECKBOX_GROUP => true,
            default => false,
        };
    }

    public function componentName(): string
    {
        return match ($this) {
            self::RADIO_GROUP => 'radio buttons',
            self::CHECKBOX_GROUP => 'checkboxes',
            self::OVERFLOW_MENU => 'overflow menu',
            self::SELECT_MENU => 'select menu',
        };
    }
}
