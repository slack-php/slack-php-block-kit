<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit;

use SlackPhp\BlockKit\Blocks\Virtual;
use SlackPhp\BlockKit\Elements\Selects;
use SlackPhp\BlockKit\Elements\RichTexts;

enum Type: string
{
    // Surfaces
    case APP_HOME       = 'home';
    case ATTACHMENT     = 'attachment';
    case MESSAGE        = 'message';
    case MODAL          = 'modal';
    case OPTIONS_RESULT = 'options_result';
    case WORKFLOW_STEP  = 'workflow_step';

    // Blocks
    case ACTIONS     = 'actions';
    case BLOCK_IMAGE = 'block_image';
    case CONTEXT     = 'context';
    case DIVIDER     = 'divider';
    case FILE        = 'file';
    case HEADER      = 'header';
    case INPUT       = 'input';
    case RICH_TEXT   = 'rich_text';
    case SECTION     = 'section';
    case VIDEO       = 'video';

    // Elements
    case BROADCAST                  = 'broadcast';
    case BUTTON                     = 'button';
    case CHANNEL                    = 'channel';
    case CHECKBOXES                 = 'checkboxes';
    case COLOR                      = 'color';
    case DATE                       = 'date';
    case DATEPICKER                 = 'datepicker';
    case EMOJI                      = 'emoji';
    case IMAGE                      = 'image';
    case LINK                       = 'link';
    case MULTI_SELECT_CHANNELS      = 'multi_channels_select';
    case MULTI_SELECT_CONVERSATIONS = 'multi_conversations_select';
    case MULTI_SELECT_EXTERNAL      = 'multi_external_select';
    case MULTI_SELECT_STATIC        = 'multi_static_select';
    case MULTI_SELECT_USERS         = 'multi_users_select';
    case NUMBER_INPUT               = 'number_input';
    case OVERFLOW_MENU              = 'overflow';
    case PLAIN_TEXT_INPUT           = 'plain_text_input';
    case RADIO_BUTTONS              = 'radio_buttons';
    case RICH_TEXT_LIST             = 'rich_text_list';
    case RICH_TEXT_PREFORMATTED     = 'rich_text_preformatted';
    case RICH_TEXT_QUOTE            = 'rich_text_quote';
    case RICH_TEXT_SECTION          = 'rich_text_section';
    case SELECT_CHANNELS            = 'channels_select';
    case SELECT_CONVERSATIONS       = 'conversations_select';
    case SELECT_EXTERNAL            = 'external_select';
    case SELECT_STATIC              = 'static_select';
    case SELECT_USERS               = 'users_select';
    case TEXT                       = 'text';
    case TIMEPICKER                 = 'timepicker';
    case USER                       = 'user';
    case USERGROUP                  = 'usergroup';

    // Parts (aka Composition Objects)
    case CONFIRM                = 'confirm';
    case DISPATCH_ACTION_CONFIG = 'dispatch_action_config';
    case FIELDS                 = 'fields';
    case FILTER                 = 'filter';
    case MENTION_STYLE          = 'mention_style';
    case MRKDWNTEXT             = 'mrkdwn';
    case OPTION                 = 'option';
    case OPTION_GROUP           = 'option_group';
    case PLAINTEXT              = 'plain_text';
    case STYLE                  = 'style';

    /** @var array<string, self> */
    private const TYPE_MAP = [
        // Surfaces
        Surfaces\AppHome::class       => self::APP_HOME,
        Surfaces\Attachment::class    => self::ATTACHMENT,
        Surfaces\Message::class       => self::MESSAGE,
        Surfaces\Modal::class         => self::MODAL,
        Surfaces\OptionsResult::class => self::OPTIONS_RESULT,
        Surfaces\WorkflowStep::class  => self::WORKFLOW_STEP,

        // Blocks
        Blocks\Actions::class    => self::ACTIONS,
        Blocks\BlockImage::class => self::BLOCK_IMAGE,
        Blocks\Context::class    => self::CONTEXT,
        Blocks\Divider::class    => self::DIVIDER,
        Blocks\File::class       => self::FILE,
        Blocks\Header::class     => self::HEADER,
        Blocks\Input::class      => self::INPUT,
        Blocks\RichText::class   => self::RICH_TEXT,
        Blocks\Section::class    => self::SECTION,
        Blocks\Video::class      => self::VIDEO,

        // Virtual Blocks
        Virtual\CodeBlock::class      => self::SECTION,
        Virtual\TwoColumnTable::class => self::SECTION,

        // Elements
        Elements\Button::class         => self::BUTTON,
        Elements\Checkboxes::class     => self::CHECKBOXES,
        Elements\DatePicker::class     => self::DATEPICKER,
        Elements\Image::class          => self::IMAGE,
        Elements\NumberInput::class    => self::NUMBER_INPUT,
        Elements\OverflowMenu::class   => self::OVERFLOW_MENU,
        Elements\PlainTextInput::class => self::PLAIN_TEXT_INPUT,
        Elements\RadioButtons::class   => self::RADIO_BUTTONS,
        Elements\TimePicker::class     => self::TIMEPICKER,

        // Menus
        Selects\ChannelSelectMenu::class           => self::SELECT_CHANNELS,
        Selects\ConversationSelectMenu::class      => self::SELECT_CONVERSATIONS,
        Selects\ExternalSelectMenu::class          => self::SELECT_EXTERNAL,
        Selects\MultiChannelSelectMenu::class      => self::MULTI_SELECT_CHANNELS,
        Selects\MultiConversationSelectMenu::class => self::MULTI_SELECT_CONVERSATIONS,
        Selects\MultiExternalSelectMenu::class     => self::MULTI_SELECT_EXTERNAL,
        Selects\MultiStaticSelectMenu::class       => self::MULTI_SELECT_STATIC,
        Selects\MultiUserSelectMenu::class         => self::MULTI_SELECT_USERS,
        Selects\StaticSelectMenu::class            => self::SELECT_STATIC,
        Selects\UserSelectMenu::class              => self::SELECT_USERS,

        // Rich Texts
        RichTexts\Broadcast::class            => self::BROADCAST,
        RichTexts\Channel::class              => self::CHANNEL,
        RichTexts\Color::class                => self::COLOR,
        RichTexts\Date::class                 => self::DATE,
        RichTexts\Emoji::class                => self::EMOJI,
        RichTexts\Link::class                 => self::LINK,
        RichTexts\RichTextList::class         => self::RICH_TEXT_LIST,
        RichTexts\RichTextPreformatted::class => self::RICH_TEXT_PREFORMATTED,
        RichTexts\RichTextQuote::class        => self::RICH_TEXT_QUOTE,
        RichTexts\RichTextSection::class      => self::RICH_TEXT_SECTION,
        RichTexts\Text::class                 => self::TEXT,
        RichTexts\User::class                 => self::USER,
        RichTexts\Usergroup::class            => self::USERGROUP,

        // Parts (aka Composition Objects)
        Parts\Confirm::class              => self::CONFIRM,
        Parts\DispatchActionConfig::class => self::DISPATCH_ACTION_CONFIG,
        Parts\Fields::class               => self::FIELDS,
        Parts\Filter::class               => self::FILTER,
        Parts\MentionStyle::class         => self::MENTION_STYLE,
        Parts\MrkdwnText::class           => self::MRKDWNTEXT,
        Parts\Option::class               => self::OPTION,
        Parts\OptionGroup::class          => self::OPTION_GROUP,
        Parts\PlainText::class            => self::PLAINTEXT,
        Parts\Style::class                => self::STYLE,
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

    public static function fromValue(self|string|null $value): ?self
    {
        return is_string($value) ? self::from($value) : $value;
    }
}
