<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit;

use SlackPhp\BlockKit\{Blocks, Inputs, Partials, Surfaces};
use SlackPhp\BlockKit\Inputs\SelectMenus;

abstract class Type
{
    // Surfaces
    public const APP_HOME      = 'home';
    public const ATTACHMENT    = 'attachment';
    public const MESSAGE       = 'message';
    public const MODAL         = 'modal';
    public const WORKFLOW_STEP = 'workflow_step';

    // Blocks
    public const ACTIONS = 'actions';
    public const CONTEXT = 'context';
    public const DIVIDER = 'divider';
    public const FILE    = 'file';
    public const HEADER  = 'header';
    public const IMAGE   = 'image';
    public const INPUT   = 'input';
    public const SECTION = 'section';

    // Inputs
    public const BUTTON        = 'button';
    public const CHECKBOXES    = 'checkboxes';
    public const DATEPICKER    = 'datepicker';
    public const TEXT_INPUT    = 'plain_text_input';
    public const TIMEPICKER    = 'timepicker';
    public const OVERFLOW_MENU = 'overflow';
    public const RADIO_BUTTONS = 'radio_buttons';

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
    public const CONFIRM                = 'confirm';
    public const DISPATCH_ACTION_CONFIG = 'dispatch_action_config';
    public const FIELDS                 = 'fields';
    public const FILTER                 = 'filter';
    public const MRKDWNTEXT             = 'mrkdwn';
    public const OPTION                 = 'option';
    public const OPTION_GROUP           = 'option_group';
    public const PLAINTEXT              = 'plain_text';

    public const SURFACE_BLOCKS = [
        self::APP_HOME => [
            self::ACTIONS,
            self::CONTEXT,
            self::DIVIDER,
            self::HEADER,
            self::IMAGE,
            self::SECTION,
        ],
        self::ATTACHMENT => [
            self::ACTIONS,
            self::CONTEXT,
            self::DIVIDER,
            self::FILE,
            self::HEADER,
            self::IMAGE,
            self::INPUT,
            self::SECTION,
        ],
        self::MESSAGE => [
            self::ACTIONS,
            self::CONTEXT,
            self::DIVIDER,
            self::FILE,
            self::HEADER,
            self::IMAGE,
            self::SECTION,
        ],
        self::MODAL => [
            self::ACTIONS,
            self::CONTEXT,
            self::DIVIDER,
            self::HEADER,
            self::IMAGE,
            self::INPUT,
            self::SECTION,
        ],
        self::WORKFLOW_STEP => [
            self::ACTIONS,
            self::CONTEXT,
            self::DIVIDER,
            self::HEADER,
            self::IMAGE,
            self::INPUT,
            self::SECTION,
        ],
    ];

    public const ACCESSORY_ELEMENTS = [
        self::BUTTON,
        self::CHECKBOXES,
        self::DATEPICKER,
        self::IMAGE,
        self::MULTI_SELECT_MENU_CHANNELS,
        self::MULTI_SELECT_MENU_CONVERSATIONS,
        self::MULTI_SELECT_MENU_EXTERNAL,
        self::MULTI_SELECT_MENU_STATIC,
        self::MULTI_SELECT_MENU_USERS,
        self::OVERFLOW_MENU,
        self::RADIO_BUTTONS,
        self::SELECT_MENU_CHANNELS,
        self::SELECT_MENU_CONVERSATIONS,
        self::SELECT_MENU_EXTERNAL,
        self::SELECT_MENU_STATIC,
        self::SELECT_MENU_USERS,
        self::TEXT_INPUT,
        self::TIMEPICKER,
    ];

    public const ACTION_ELEMENTS = [
        self::BUTTON,
        self::CHECKBOXES,
        self::DATEPICKER,
        self::OVERFLOW_MENU,
        self::RADIO_BUTTONS,
        self::SELECT_MENU_CHANNELS,
        self::SELECT_MENU_CONVERSATIONS,
        self::SELECT_MENU_EXTERNAL,
        self::SELECT_MENU_STATIC,
        self::SELECT_MENU_USERS,
        self::TEXT_INPUT,
        self::TIMEPICKER,
    ];

    public const CONTEXT_ELEMENTS = [self::IMAGE, self::MRKDWNTEXT, self::PLAINTEXT];

    public const INPUT_ELEMENTS = [
        self::CHECKBOXES,
        self::DATEPICKER,
        self::MULTI_SELECT_MENU_CHANNELS,
        self::MULTI_SELECT_MENU_CONVERSATIONS,
        self::MULTI_SELECT_MENU_EXTERNAL,
        self::MULTI_SELECT_MENU_STATIC,
        self::MULTI_SELECT_MENU_USERS,
        self::RADIO_BUTTONS,
        self::SELECT_MENU_CHANNELS,
        self::SELECT_MENU_CONVERSATIONS,
        self::SELECT_MENU_EXTERNAL,
        self::SELECT_MENU_STATIC,
        self::SELECT_MENU_USERS,
        self::TEXT_INPUT,
        self::TIMEPICKER,
    ];

    public const HIDDEN_TYPES = [
        self::ATTACHMENT,
        self::CONFIRM,
        self::DISPATCH_ACTION_CONFIG,
        self::FIELDS,
        self::FILTER,
        self::MESSAGE,
        self::OPTION,
        self::OPTION_GROUP,
    ];

    /** @var array<string, string> */
    private static $typeMap = [
        // Surfaces
        Surfaces\AppHome::class      => self::APP_HOME,
        Surfaces\Attachment::class   => self::ATTACHMENT,
        Surfaces\Message::class      => self::MESSAGE,
        Surfaces\Modal::class        => self::MODAL,
        Surfaces\WorkflowStep::class => self::WORKFLOW_STEP,

        // Blocks
        Blocks\Actions::class => self::ACTIONS,
        Blocks\Context::class => self::CONTEXT,
        Blocks\Divider::class => self::DIVIDER,
        Blocks\File::class    => self::FILE,
        Blocks\Header::class  => self::HEADER,
        Blocks\Image::class   => self::IMAGE,
        Blocks\Input::class   => self::INPUT,
        Blocks\Section::class => self::SECTION,

        // Virtual Blocks
        Blocks\Virtual\TwoColumnTable::class => self::SECTION, // Composed of Sections

        // Inputs
        Inputs\Button::class       => self::BUTTON,
        Inputs\Checkboxes::class   => self::CHECKBOXES,
        Inputs\DatePicker::class   => self::DATEPICKER,
        Inputs\OverflowMenu::class => self::OVERFLOW_MENU,
        Inputs\RadioButtons::class => self::RADIO_BUTTONS,
        Inputs\TextInput::class    => self::TEXT_INPUT,
        Inputs\TimePicker::class   => self::TIMEPICKER,

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
        Partials\Confirm::class              => self::CONFIRM,
        Partials\DispatchActionConfig::class => self::DISPATCH_ACTION_CONFIG,
        Partials\Fields::class               => self::FIELDS,
        Partials\Filter::class               => self::FILTER,
        Partials\MrkdwnText::class           => self::MRKDWNTEXT,
        Partials\Option::class               => self::OPTION,
        Partials\OptionGroup::class          => self::OPTION_GROUP,
        Partials\PlainText::class            => self::PLAINTEXT,
    ];

    public static function mapClass(string $class): string
    {
        if (!isset(self::$typeMap[$class])) {
            throw new Exception('No type for class: %s', [$class]);
        }

        return self::$typeMap[$class];
    }

    public static function mapType(string $type): string
    {
        $class = array_search($type, self::$typeMap);
        if (!$class) {
            throw new Exception('No class for type: %s', [$type]);
        }

        return $class;
    }
}
