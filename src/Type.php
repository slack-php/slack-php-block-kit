<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use Jeremeamia\Slack\BlockKit\{Blocks, Inputs, Partials, Surfaces};

abstract class Type
{
    public const ACTIONS    = 'actions';
    public const BUTTON     = 'button';
    public const CONFIRM    = 'confirm';
    public const CONTEXT    = 'context';
    public const DATEPICKER = 'datepicker';
    public const DIVIDER    = 'divider';
    public const FIELDS     = 'fields';
    public const APPHOME    = 'home';
    public const IMAGE      = 'image';
    public const INPUT      = 'input';
    public const MRKDWNTEXT = 'mrkdwn';
    public const MESSAGE    = 'message';
    public const MODAL      = 'modal';
    public const PLAINTEXT  = 'plain_text';
    public const SECTION    = 'section';

    public const ACCESSORY_ELEMENTS = [Type::BUTTON, Type::DATEPICKER, Type::IMAGE];
    public const ACTION_ELEMENTS    = [Type::BUTTON, Type::DATEPICKER];
    public const CONTEXT_ELEMENTS   = [Type::IMAGE, Type::MRKDWNTEXT, Type::PLAINTEXT];
    public const INPUT_ELEMENTS     = [Type::DATEPICKER];

    private static $typeMap = [
        Blocks\Actions::class      => self::ACTIONS,
        Inputs\Button::class       => self::BUTTON,
        Partials\Confirm::class    => self::CONFIRM,
        Blocks\Context::class      => self::CONTEXT,
        Inputs\DatePicker::class   => self::DATEPICKER,
        Blocks\Divider::class      => self::DIVIDER,
        Partials\Fields::class     => self::FIELDS,
        Surfaces\AppHome::class    => self::APPHOME,
        Blocks\Image::class        => self::IMAGE,
        Blocks\Input::class        => self::INPUT,
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
