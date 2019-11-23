<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use Jeremeamia\Slack\BlockKit\{Blocks, Inputs, Partials, Surfaces};

abstract class Type
{
    public const ACTIONS    = 'actions';
    public const APPHOME    = 'home';
    public const BUTTON     = 'button';
    public const CONFIRM    = 'confirm';
    public const CONTEXT    = 'context';
    public const DATEPICKER = 'datepicker';
    public const DIVIDER    = 'divider';
    public const FIELDS     = 'fields';
    public const IMAGE      = 'image';
    public const INPUT      = 'input';
    public const MRKDWNTEXT = 'mrkdwn';
    public const MESSAGE    = 'message';
    public const MODAL      = 'modal';
    public const OPTION     = 'option';
    public const PLAINTEXT  = 'plain_text';
    public const SECTION    = 'section';

    public const SELECT_MENU = 'static_select';

    public const ACCESSORY_ELEMENTS = [Type::BUTTON, Type::DATEPICKER, Type::IMAGE];
    public const ACTION_ELEMENTS    = [Type::BUTTON, Type::DATEPICKER, Type::SELECT_MENU];
    public const CONTEXT_ELEMENTS   = [Type::IMAGE, Type::MRKDWNTEXT, Type::PLAINTEXT];
    public const INPUT_ELEMENTS     = [Type::DATEPICKER, Type::SELECT_MENU];

    private static $typeMap = [
        Blocks\Actions::class      => self::ACTIONS,
        Surfaces\AppHome::class    => self::APPHOME,
        Inputs\Button::class       => self::BUTTON,
        Partials\Confirm::class    => self::CONFIRM,
        Blocks\Context::class      => self::CONTEXT,
        Inputs\DatePicker::class   => self::DATEPICKER,
        Blocks\Divider::class      => self::DIVIDER,
        Partials\Fields::class     => self::FIELDS,
        Blocks\Image::class        => self::IMAGE,
        Blocks\Input::class        => self::INPUT,
        Partials\MrkdwnText::class => self::MRKDWNTEXT,
        Surfaces\Message::class    => self::MESSAGE,
        Surfaces\Modal::class      => self::MODAL,
        Partials\Option::class     => self::OPTION,
        Partials\PlainText::class  => self::PLAINTEXT,
        Blocks\Section::class      => self::SECTION,

        Inputs\SelectMenus\SelectMenu::class => self::SELECT_MENU,
    ];

    public static function mapClass(string $class): string
    {
        if (!isset(self::$typeMap[$class])) {
            throw new Exception("No type for class: {$class}");
        }

        return self::$typeMap[$class];
    }
}
