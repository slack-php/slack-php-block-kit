<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use Jeremeamia\Slack\BlockKit\{Blocks, Inputs, Inputs\SelectMenus, Partials, Surfaces};

abstract class Type
{
    // Surfaces
    public const APPHOME = 'home';
    public const MESSAGE = 'message';
    public const MODAL   = 'modal';

    // Blocks
    public const ACTIONS = 'actions';
    public const CONTEXT = 'context';
    public const DIVIDER = 'divider';
    // public const FILE = 'file'; // Not yet supported.
    public const IMAGE   = 'image';
    public const INPUT   = 'input';
    public const SECTION = 'section';

    // Inputs
    public const BUTTON            = 'button';
    public const DATEPICKER        = 'datepicker';
    public const TEXT_INPUT        = 'plain_text_input';
    // public const OVERFLOW_MENU  = 'overflow'; // Not yet supported.
    // public const RADIO_BUTTONS  = 'radio_buttons'; // Not yet supported.

    // Select Menus
    public const MULTI_SELECT_MENU_CHANNELS      = 'multi_channels_select';
    public const MULTI_SELECT_MENU_CONVERSATIONS = 'multi_conversations_select';
    public const MULTI_SELECT_MENU_EXTERNAL      = 'multi_external_select';
    public const MULTI_SELECT_MENU_STATIC        = 'multi_static_select';
    public const MULTI_SELECT_MENU_USERS         = 'multi_users_select';
    public const SELECT_MENU_CHANNELS            = 'channels_select';
    public const SELECT_MENU_CONVERSATIONS       = 'conversations_select';
    public const SELECT_MENU_EXTERNAL            = 'external_select';
    public const SELECT_MENU_STATIC              = 'static_select';
    public const SELECT_MENU_USERS               = 'users_select';

    // Partials
    public const CONFIRM      = 'confirm';
    public const FIELDS       = 'fields';
    public const MRKDWNTEXT   = 'mrkdwn';
    public const OPTION       = 'option';
    public const OPTION_GROUP = 'option_group';
    public const PLAINTEXT    = 'plain_text';

    public const SURFACE_BLOCKS = [
        self::APPHOME => [
            self::ACTIONS,
            self::CONTEXT,
            self::DIVIDER,
            self::IMAGE,
            self::SECTION,
        ],
        self::MESSAGE => [
            self::ACTIONS,
            self::CONTEXT,
            self::DIVIDER,
            // self::FILE, // Not yet supported.
            self::IMAGE,
            self::SECTION,
        ],
        self::MODAL => [
            self::ACTIONS,
            self::CONTEXT,
            self::DIVIDER,
            self::IMAGE,
            self::INPUT,
            self::SECTION,
        ],
    ];

    public const ACCESSORY_ELEMENTS = [
        self::BUTTON,
        self::DATEPICKER,
        self::IMAGE,
        self::MULTI_SELECT_MENU_CHANNELS,
        self::MULTI_SELECT_MENU_CONVERSATIONS,
        self::MULTI_SELECT_MENU_EXTERNAL,
        self::MULTI_SELECT_MENU_STATIC,
        self::MULTI_SELECT_MENU_USERS,
        // self::OVERFLOW_MENU, // Not yet supported.
        // self::RADIO_BUTTONS, // Not yet supported.
        self::SELECT_MENU_CHANNELS,
        self::SELECT_MENU_CONVERSATIONS,
        self::SELECT_MENU_EXTERNAL,
        self::SELECT_MENU_STATIC,
        self::SELECT_MENU_USERS,
        self::TEXT_INPUT,
    ];

    public const ACTION_ELEMENTS = [
        self::BUTTON,
        self::DATEPICKER,
        // self::OVERFLOW_MENU, // Not yet supported.
        // self::RADIO_BUTTONS, // Not yet supported.
        self::SELECT_MENU_CHANNELS,
        self::SELECT_MENU_CONVERSATIONS,
        self::SELECT_MENU_EXTERNAL,
        self::SELECT_MENU_STATIC,
        self::SELECT_MENU_USERS,
        self::TEXT_INPUT,
    ];

    public const CONTEXT_ELEMENTS = [self::IMAGE, self::MRKDWNTEXT, self::PLAINTEXT];

    public const INPUT_ELEMENTS = [
        self::DATEPICKER,
        self::MULTI_SELECT_MENU_CHANNELS,
        self::MULTI_SELECT_MENU_CONVERSATIONS,
        self::MULTI_SELECT_MENU_EXTERNAL,
        self::MULTI_SELECT_MENU_STATIC,
        self::MULTI_SELECT_MENU_USERS,
        // self::RADIO_BUTTONS, // Not yet supported.
        self::SELECT_MENU_CHANNELS,
        self::SELECT_MENU_CONVERSATIONS,
        self::SELECT_MENU_EXTERNAL,
        self::SELECT_MENU_STATIC,
        self::SELECT_MENU_USERS,
        self::TEXT_INPUT,
    ];

    public const HIDDEN_TYPES = [self::MESSAGE, self::FIELDS, self::CONFIRM, self::OPTION, self::OPTION_GROUP];

    private static $typeMap = [
        // Surfaces
        Surfaces\AppHome::class => self::APPHOME,
        Surfaces\Message::class => self::MESSAGE,
        Surfaces\Modal::class   => self::MODAL,

        // Blocks
        Blocks\Actions::class => self::ACTIONS,
        Blocks\Context::class => self::CONTEXT,
        Blocks\Divider::class => self::DIVIDER,
        // Block\File::class  => self::FILE, // Not yet supported.
        Blocks\Image::class   => self::IMAGE,
        Blocks\Input::class   => self::INPUT,
        Blocks\Section::class => self::SECTION,

        // Virtual Blocks
        Blocks\Virtual\TwoColumnTable::class => self::SECTION, // Composed of Sections

        // Inputs
        Inputs\Button::class          => self::BUTTON,
        Inputs\DatePicker::class      => self::DATEPICKER,
        // Inputs\OverflowMenu::class => self::OVERFLOW_MENU, // Not yet supported.
        // Inputs\RadioButtons::class => self::RADIO_BUTTONS, // Not yet supported.
        Inputs\TextInput::class    => self::TEXT_INPUT,

        // Select Menus
        SelectMenus\MultiChannelSelectMenu::class       => self::MULTI_SELECT_MENU_CHANNELS,
        SelectMenus\MultiConversationSelectMenu::class  => self::MULTI_SELECT_MENU_CONVERSATIONS,
        SelectMenus\MultiExternalSelectMenu::class      => self::MULTI_SELECT_MENU_EXTERNAL,
        SelectMenus\MultiStaticSelectMenu::class        => self::MULTI_SELECT_MENU_STATIC,
        SelectMenus\MultiUserSelectMenu::class          => self::MULTI_SELECT_MENU_USERS,
        SelectMenus\ChannelSelectMenu::class            => self::SELECT_MENU_CHANNELS,
        SelectMenus\ConversationSelectMenu::class       => self::SELECT_MENU_CONVERSATIONS,
        SelectMenus\ExternalSelectMenu::class           => self::SELECT_MENU_EXTERNAL,
        SelectMenus\StaticSelectMenu::class             => self::SELECT_MENU_STATIC,
        SelectMenus\UserSelectMenu::class               => self::SELECT_MENU_USERS,

        // Partials
        Partials\Confirm::class     => self::CONFIRM,
        Partials\Fields::class      => self::FIELDS,
        Partials\MrkdwnText::class  => self::MRKDWNTEXT,
        Partials\Option::class      => self::OPTION,
        Partials\OptionGroup::class => self::OPTION_GROUP,
        Partials\PlainText::class   => self::PLAINTEXT,
    ];

    public static function mapClass(string $class): string
    {
        if (!isset(self::$typeMap[$class])) {
            throw new Exception('No type for class: %s', [$class]);
        }

        return self::$typeMap[$class];
    }
}
