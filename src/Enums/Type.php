<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Enums;

use SlackPhp\BlockKit\{Blocks, Elements, Exception, Parts, Surfaces};
use SlackPhp\BlockKit\Blocks\Virtual;
use SlackPhp\BlockKit\Elements\Selects;

enum Type: string
{
    // Surfaces
    case APP_HOME      = 'home';
    case ATTACHMENT    = 'attachment';
    case MESSAGE       = 'message';
    case MODAL         = 'modal';
    case WORKFLOW_STEP = 'workflow_step';

    // Blocks
    case ACTIONS     = 'actions';
    case BLOCK_IMAGE = 'block_image';
    case CONTEXT     = 'context';
    case DIVIDER     = 'divider';
    case FILE        = 'file';
    case HEADER      = 'header';
    case INPUT       = 'input';
    case SECTION     = 'section';

    // Elements
    case BUTTON                     = 'button';
    case CHECKBOXES                 = 'checkboxes';
    case DATEPICKER                 = 'datepicker';
    case IMAGE                      = 'image';
    case MULTI_SELECT_CHANNELS      = 'multi_channels_select';
    case MULTI_SELECT_CONVERSATIONS = 'multi_conversations_select';
    case MULTI_SELECT_EXTERNAL      = 'multi_external_select';
    case MULTI_SELECT_STATIC        = 'multi_static_select';
    case MULTI_SELECT_USERS         = 'multi_users_select';
    case OVERFLOW_MENU              = 'overflow';
    case RADIO_BUTTONS              = 'radio_buttons';
    case SELECT_CHANNELS            = 'channels_select';
    case SELECT_CONVERSATIONS       = 'conversations_select';
    case SELECT_EXTERNAL            = 'external_select';
    case SELECT_STATIC              = 'static_select';
    case SELECT_USERS               = 'users_select';
    case TEXT_INPUT                 = 'plain_text_input';
    case TIMEPICKER                 = 'timepicker';

    // Parts (aka Composition Objects)
    case CONFIRM                = 'confirm';
    case DISPATCH_ACTION_CONFIG = 'dispatch_action_config';
    case FIELDS                 = 'fields';
    case FILTER                 = 'filter';
    case MRKDWNTEXT             = 'mrkdwn';
    case OPTION                 = 'option';
    case OPTION_GROUP           = 'option_group';
    case PLAINTEXT              = 'plain_text';

    /** @var array<string, self> */
    private const TYPE_MAP = [
        // Surfaces
        Surfaces\AppHome::class      => self::APP_HOME,
        Surfaces\Attachment::class   => self::ATTACHMENT,
        Surfaces\Message::class      => self::MESSAGE,
        Surfaces\Modal::class        => self::MODAL,
        Surfaces\WorkflowStep::class => self::WORKFLOW_STEP,

        // Blocks
        Blocks\Actions::class    => self::ACTIONS,
        Blocks\BlockImage::class => self::BLOCK_IMAGE,
        Blocks\Context::class    => self::CONTEXT,
        Blocks\Divider::class    => self::DIVIDER,
        Blocks\File::class       => self::FILE,
        Blocks\Header::class     => self::HEADER,
        Blocks\Input::class      => self::INPUT,
        Blocks\Section::class    => self::SECTION,

        // Virtual Blocks
        Virtual\CodeBlock::class      => self::SECTION,
        Virtual\TwoColumnTable::class => self::SECTION,

        // Elements
        Elements\Button::class       => self::BUTTON,
        Elements\Checkboxes::class   => self::CHECKBOXES,
        Elements\DatePicker::class   => self::DATEPICKER,
        Elements\Image::class        => self::IMAGE,
        Elements\RadioButtons::class => self::RADIO_BUTTONS,
        Elements\PlainTextInput::class    => self::TEXT_INPUT,
        Elements\TimePicker::class   => self::TIMEPICKER,

        // Menus
        Elements\OverflowMenu::class                 => self::OVERFLOW_MENU,
        Selects\MultiChannelSelectMenu::class       => self::MULTI_SELECT_CHANNELS,
        Selects\MultiConversationSelectMenu::class  => self::MULTI_SELECT_CONVERSATIONS,
        Selects\MultiExternalSelectMenu::class      => self::MULTI_SELECT_EXTERNAL,
        Selects\MultiStaticSelectMenu::class        => self::MULTI_SELECT_STATIC,
        Selects\MultiUserSelectMenu::class          => self::MULTI_SELECT_USERS,
        Selects\ChannelSelectMenu::class            => self::SELECT_CHANNELS,
        Selects\ConversationSelectMenu::class       => self::SELECT_CONVERSATIONS,
        Selects\ExternalSelectMenu::class           => self::SELECT_EXTERNAL,
        Selects\StaticSelectMenu::class             => self::SELECT_STATIC,
        Selects\UserSelectMenu::class               => self::SELECT_USERS,

        // Parts (aka Composition Objects)
        Parts\Confirm::class              => self::CONFIRM,
        Parts\DispatchActionConfig::class => self::DISPATCH_ACTION_CONFIG,
        Parts\Fields::class               => self::FIELDS,
        Parts\Filter::class               => self::FILTER,
        Parts\MrkdwnText::class           => self::MRKDWNTEXT,
        Parts\Option::class               => self::OPTION,
        Parts\OptionGroup::class          => self::OPTION_GROUP,
        Parts\PlainText::class            => self::PLAINTEXT,
    ];

    public static function fromClass(string $class): self
    {
        if (!isset(self::TYPE_MAP[$class])) {
            throw new Exception('No type for class: %s', [$class]);
        }

        return self::TYPE_MAP[$class];
    }

    public function toClass(): string
    {
        $class = array_search($this, self::TYPE_MAP, true);
        if (!$class) {
            throw new Exception('No class for type: %s', [$this->value]);
        }

        return $class;
    }

    public function toSlackValue(): ?string
    {
        return match ($this) {
            self::ATTACHMENT, self::CONFIRM, self::DISPATCH_ACTION_CONFIG, self::FIELDS,
                self::FILTER, self::MESSAGE, self::OPTION, self::OPTION_GROUP => null,
            self::BLOCK_IMAGE => self::IMAGE->value,
            default => $this->value,
        };
    }

    public static function fromValue(self|string|null $value): ?self
    {
        return is_string($value) ? self::from($value) : $value;
    }
}
