<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use Jeremeamia\Slack\BlockKit\{Blocks, Inputs, Partials, Surfaces};

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

    private static $typeMap = [
        Inputs\Button::class       => self::BUTTON,
        Blocks\Context::class      => self::CONTEXT,
        Blocks\Divider::class      => self::DIVIDER,
        Partials\Fields::class     => self::FIELDS,
        Surfaces\AppHome::class    => self::APPHOME,
        Blocks\Image::class        => self::IMAGE,
        Partials\MrkdwnText::class => self::MRKDWNTEXT,
        Surfaces\Message::class    => self::MESSAGE,
        Surfaces\Modal::class      => self::MODAL,
        Partials\PlainText::class  => self::PLAINTEXT,
        Blocks\Section::class      => self::SECTION,
    ];

    public static function mapClass(string $class): string
    {
        if (!isset(self::$typeMap[$class])) {
            throw new Exception("No type for class: {$class}");
        }

        return self::$typeMap[$class];
    }
}
