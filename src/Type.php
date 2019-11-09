<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use Jeremeamia\Slack\BlockKit\{Surfaces, Blocks, Partials, Actions};

abstract class Type
{
    public const BUTTON     = 'button';
    public const CONTEXT    = 'context';
    public const DIVIDER    = 'divider';
    public const FIELDS     = 'fields';
    public const APPHOME    = 'home';
    public const IMAGE      = 'image';
    public const MRKDWNTEXT = 'mrkdwn';
    public const MESSAGE    = 'message';
    public const MODAL      = 'modal';
    public const PLAINTEXT  = 'plain_text';
    public const SECTION    = 'section';

    private static $types = [
        self::BUTTON     => Actions\Button::class,
        self::CONTEXT    => Blocks\Context::class,
        self::DIVIDER    => Blocks\Divider::class,
        self::FIELDS     => Partials\Fields::class,
        self::APPHOME    => Surfaces\AppHome::class,
        self::IMAGE      => Blocks\Image::class,
        self::MRKDWNTEXT => Partials\MrkdwnText::class,
        self::MESSAGE    => Surfaces\Message::class,
        self::MODAL      => Surfaces\Modal::class,
        self::PLAINTEXT  => Partials\PlainText::class,
        self::SECTION    => Blocks\Section::class,
    ];

    public static function mapToClass(string $type): string
    {
        if (!isset(self::$types[$type])) {
            throw new Exception("No such type: {$type}");
        }

        return self::$types[$type];
    }

    public static function mapToType(string $class): string
    {
        $types = array_flip(self::$types);

        if (!isset($types[$class])) {
            throw new Exception("No type for class: {$class}");
        }

        return $types[$class];
    }
}
