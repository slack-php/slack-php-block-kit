<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit;

/**
 * Kit acts as a static façade to the whole block kit library.
 */
abstract class Kit
{
    #region Surfaces
    /**
     * @param Collections\BlockCollection|array<Blocks\Block|string>|null $blocks
     */
    public static function appHome(
        Collections\BlockCollection|array|null $blocks = null,
        ?string $callbackId = null,
        ?string $externalId = null,
        PrivateMetadata|array|string|null $privateMetadata = null,
    ): Surfaces\AppHome {
        return new Surfaces\AppHome($blocks, $callbackId, $externalId, $privateMetadata);
    }

    /**
     * @param Collections\BlockCollection|array<Blocks\Block|string>|null $blocks
     */
    public static function attachment(
        Collections\BlockCollection|array|null $blocks = null,
        ?string $color = null,
    ): Surfaces\Attachment {
        return new Surfaces\Attachment($blocks, $color);
    }

    /**
     * @param Collections\BlockCollection|array<Blocks\Block|string>|null $blocks
     * @param Collections\AttachmentCollection|array<Surfaces\Attachment>|null $attachments
     */
    public static function message(
        Collections\BlockCollection|array|null $blocks = null,
        ?Surfaces\MessageDirective\ResponseType $responseType = null,
        ?string $text = null,
        Collections\AttachmentCollection|array|null $attachments = null,
        ?bool $mrkdwn = null,
        ?string $threadTs = null,
    ): Surfaces\Message {
        return new Surfaces\Message($blocks, $responseType, $text, $attachments, $mrkdwn, $threadTs);
    }

    /**
     * @param Collections\BlockCollection|array<Blocks\Block|string>|null $blocks
     */
    public static function modal(
        Collections\BlockCollection|array|null $blocks = null,
        Parts\PlainText|string|null $title = null,
        ?string $callbackId = null,
        ?string $externalId = null,
        PrivateMetadata|array|string|null $privateMetadata = null,
        Parts\PlainText|string|null $submit = null,
        Parts\PlainText|string|null $close = null,
        ?bool $clearOnClose = null,
        ?bool $notifyOnClose = null,
    ): Surfaces\Modal {
        return new Surfaces\Modal($blocks, $title, $callbackId, $externalId, $privateMetadata, $submit, $close, $clearOnClose, $notifyOnClose);
    }

    /**
     * @param Collections\OptionSet|array<Parts\Option|string>|array<string, string>|null $options
     * @param Collections\OptionGroupCollection|array<Parts\OptionGroup|null>|array<string, Collections\OptionSet|array<string, string>>|null $optionGroups
     */
    public static function optionsResult(
        Collections\OptionSet|array|null $options = null,
        Collections\OptionGroupCollection|array|null $optionGroups = null,
    ): Surfaces\OptionsResult {
        return new Surfaces\OptionsResult($options, $optionGroups);
    }

    /**
     * @param Collections\BlockCollection|array<Blocks\Block|string>|null $blocks
     */
    public static function workflowStep(
        Collections\BlockCollection|array|null $blocks = null,
        ?string $callbackId = null,
        PrivateMetadata|array|string|null $privateMetadata = null,
        ?bool $submitDisabled = null,
    ): Surfaces\WorkflowStep {
        return new Surfaces\WorkflowStep($blocks, $callbackId, $privateMetadata, $submitDisabled);
    }
    #endregion

    #region Blocks
    /**
     * @param Collections\ActionCollection|array<Elements\Button|Elements\Checkboxes|Elements\DatePicker|Elements\OverflowMenu|Elements\RadioButtons|Elements\Selects\SelectMenu|Elements\TimePicker|null> $elements
     */
    public static function actions(Collections\ActionCollection|array $elements = [], ?string $blockId = null): Blocks\Actions
    {
        return new Blocks\Actions($elements, $blockId);
    }

    public static function blockImage(
        ?string $imageUrl = null,
        ?string $altText = null,
        Parts\PlainText|string|null $title = null,
        ?string $blockId = null,
    ): Blocks\BlockImage {
        return new Blocks\BlockImage($imageUrl, $altText, $title, $blockId);
    }

    /**
     * @param Collections\ContextCollection|array<Elements\Image|Parts\MrkdwnText|Parts\PlainText|string|null> $elements
     */
    public static function context(Collections\ContextCollection|array $elements = [], ?string $blockId = null): Blocks\Context
    {
        return new Blocks\Context($elements, $blockId);
    }

    public static function divider(?string $blockId = null): Blocks\Divider
    {
        return new Blocks\Divider($blockId);
    }

    public static function file(
        ?string $externalId = null,
        ?string $source = 'remote',
        ?string $blockId = null,
    ): Blocks\File {
        return new Blocks\File($externalId, $source, $blockId);
    }

    public static function header(Parts\PlainText|string|null $text = null, ?string $blockId = null): Blocks\Header
    {
        return new Blocks\Header($text, $blockId);
    }

    public static function input(
        Parts\PlainText|string|null $label = null,
        ?Elements\Input $element = null,
        ?bool $optional = null,
        Parts\PlainText|string|null $hint = null,
        ?bool $dispatchAction = null,
        ?string $blockId = null,
    ): Blocks\Input {
        return new Blocks\Input($label, $element, $optional, $hint, $dispatchAction, $blockId);
    }

    /**
     * @see https://api.slack.com/reference/block-kit/blocks#rich_text
     */
    public static function richText(
        Collections\RichTextSubCollection|array $elements = [],
        ?string $blockId = null,
    ): Blocks\RichText {
        return new Blocks\RichText($elements, $blockId);
    }

    public static function section(
        Parts\Text|string|null $text = null,
        Parts\Fields|array|null $fields = null,
        ?Elements\Element $accessory = null,
        ?string $blockId = null
    ): Blocks\Section {
        return new Blocks\Section($text, $fields, $accessory, $blockId);
    }

    public static function video(
        Parts\PlainText|string|null $title = null,
        ?string $videoUrl = null,
        ?string $thumbnailUrl = null,
        ?string $altText = null,
        Parts\PlainText|string|null $description = null,
        ?string $authorName = null,
        ?string $titleUrl = null,
        ?string $providerName = null,
        ?string $providerIconUrl = null,
        ?string $blockId = null,
    ): Blocks\Video {
        return new Blocks\Video($title, $videoUrl, $thumbnailUrl, $altText, $description, $authorName, $titleUrl, $providerName, $providerIconUrl, $blockId);
    }
    #endregion

    #region Elements
    /**
     * @see https://api.slack.com/reference/block-kit/blocks#broadcast-element-type
     */
    public static function broadcast(
        Elements\RichTexts\Range|string|null $range = null,
    ): Elements\RichTexts\Broadcast {
        return new Elements\RichTexts\Broadcast($range);
    }

    public static function button(
        ?string $actionId = null,
        Parts\PlainText|string|null $text = null,
        ?string $value = null,
        Elements\ButtonStyle|string|null $style = null,
        ?string $url = null,
        ?Parts\Confirm $confirm = null,
        ?string $accessibilityLabel = null,
    ): Elements\Button {
        return new Elements\Button($actionId, $text, $value, $style, $url, $confirm, $accessibilityLabel);
    }

    /**
     * @see https://api.slack.com/reference/block-kit/blocks#channel-element-type
     */
    public static function channel(
        ?string $channelId = null,
        ?Parts\MentionStyle $style = null,
    ): Elements\RichTexts\Channel {
        return new Elements\RichTexts\Channel($channelId, $style);
    }

    public static function channelSelectMenu(
        ?string $actionId = null,
        Parts\PlainText|string|null $placeholder = null,
        ?string $initialChannel = null,
        ?bool $responseUrlEnabled = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\Selects\ChannelSelectMenu {
        return new Elements\Selects\ChannelSelectMenu($actionId, $placeholder, $initialChannel, $responseUrlEnabled, $confirm, $focusOnLoad);
    }

    /**
     * @param Collections\OptionSet|array<Parts\Option|string>|array<string, string>|null $options
     * @param Collections\OptionSet|array<Parts\Option|string>|array<string, string>|null $initialOptions
     */
    public static function checkboxes(
        ?string $actionId = null,
        Collections\OptionSet|array|null $options = null,
        Collections\OptionSet|array|null $initialOptions = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\Checkboxes {
        return new Elements\Checkboxes($actionId, $options, $initialOptions, $confirm, $focusOnLoad);
    }

    /**
     * @see https://api.slack.com/reference/block-kit/blocks#color-element-type
     */
    public static function color(?string $value = null): Elements\RichTexts\Color
    {
        return new Elements\RichTexts\Color($value);
    }

    public static function conversationSelectMenu(
        ?string $actionId = null,
        Parts\PlainText|string|null $placeholder = null,
        ?string $initialConversation = null,
        ?bool $responseUrlEnabled = null,
        ?bool $defaultToCurrentConversation = null,
        ?Parts\Filter $filter = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\Selects\ConversationSelectMenu {
        return new Elements\Selects\ConversationSelectMenu($actionId, $placeholder, $initialConversation, $responseUrlEnabled, $defaultToCurrentConversation, $filter, $confirm, $focusOnLoad);
    }

    /**
     * @see https://api.slack.com/reference/block-kit/blocks#date-element-type
     */
    public static function date(
        ?int $timestamp = null,
        ?string $format = null,
        ?string $url = null,
        ?string $fallback = null,
    ): Elements\RichTexts\Date {
        return new Elements\RichTexts\Date($timestamp, $format, $url, $fallback);
    }

    public static function datePicker(
        ?string $actionId = null,
        \DateTime|string|null $initialDate = null,
        ?string $placeholder = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\DatePicker {
        return new Elements\DatePicker($actionId, $initialDate, $placeholder, $confirm, $focusOnLoad);
    }

    /**
     * @see https://api.slack.com/reference/block-kit/blocks#emoji-element-type
     */
    public static function emoji(?string $name = null, ?string $unicode = null): Elements\RichTexts\Emoji
    {
        return new Elements\RichTexts\Emoji($name, $unicode);
    }

    public static function externalSelectMenu(
        ?string $actionId = null,
        Parts\PlainText|string|null $placeholder = null,
        ?int $minQueryLength = null,
        Parts\Option|string|null $initialOption = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\Selects\ExternalSelectMenu {
        return new Elements\Selects\ExternalSelectMenu($actionId, $placeholder, $minQueryLength, $initialOption, $confirm, $focusOnLoad);
    }

    public static function image(?string $imageUrl = null, ?string $altText = null): Elements\Image
    {
        return new Elements\Image($imageUrl, $altText);
    }

    /**
     * @see https://api.slack.com/reference/block-kit/blocks#link-element-type
     */
    public static function link(
        ?string $url = null,
        ?string $text = null,
        ?bool $unsafe = null,
        ?Parts\Style $style = null,
    ): Elements\RichTexts\Link {
        return new Elements\RichTexts\Link($url, $text, $unsafe, $style);
    }

    /**
     * @param string[]|null $initialChannels
     */
    public static function multiChannelSelectMenu(
        ?string $actionId = null,
        Parts\PlainText|string|null $placeholder = null,
        ?array $initialChannels = null,
        ?int $maxSelectedItems = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\Selects\MultiChannelSelectMenu {
        return new Elements\Selects\MultiChannelSelectMenu($actionId, $placeholder, $initialChannels, $maxSelectedItems, $confirm, $focusOnLoad);
    }

    /**
     * @param string[]|null $initialConversations
     */
    public static function multiConversationSelectMenu(
        ?string $actionId = null,
        Parts\PlainText|string|null $placeholder = null,
        ?array $initialConversations = null,
        ?bool $defaultToCurrentConversation = null,
        ?Parts\Filter $filter = null,
        ?int $maxSelectedItems = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\Selects\MultiConversationSelectMenu {
        return new Elements\Selects\MultiConversationSelectMenu($actionId, $placeholder, $initialConversations, $defaultToCurrentConversation, $filter, $maxSelectedItems, $confirm, $focusOnLoad);
    }

    /**
     * @param Collections\OptionSet|array<Parts\Option|string>|array<string, string>|null $initialOptions
     */
    public static function multiExternalSelectMenu(
        ?string $actionId = null,
        Parts\PlainText|string|null $placeholder = null,
        ?int $minQueryLength = null,
        Collections\OptionSet|array|null $initialOptions = null,
        ?int $maxSelectedItems = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\Selects\MultiExternalSelectMenu {
        return new Elements\Selects\MultiExternalSelectMenu($actionId, $placeholder, $minQueryLength, $initialOptions, $maxSelectedItems, $confirm, $focusOnLoad);
    }

    /**
     * @param Collections\OptionSet|array<Parts\Option|string>|array<string, string>|null $options
     * @param Collections\OptionGroupCollection|array<Parts\OptionGroup|null>|array<string, Collections\OptionSet|array<string, string>>|null $optionGroups
     * @param Collections\OptionSet|array<Parts\Option|string>|array<string, string>|null $initialOptions
     */
    public static function multiStaticSelectMenu(
        ?string $actionId = null,
        Parts\PlainText|string|null $placeholder = null,
        Collections\OptionSet|array|null $options = null,
        Collections\OptionGroupCollection|array|null $optionGroups = null,
        Collections\OptionSet|array|null $initialOptions = null,
        ?int $maxSelectedItems = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\Selects\MultiStaticSelectMenu {
        return new Elements\Selects\MultiStaticSelectMenu($actionId, $placeholder, $options, $optionGroups, $initialOptions, $maxSelectedItems, $confirm, $focusOnLoad);
    }

    /**
     * @param string[]|null $initialUsers
     */
    public static function multiUserSelectMenu(
        ?string $actionId = null,
        Parts\PlainText|string|null $placeholder = null,
        ?array $initialUsers = null,
        ?int $maxSelectedItems = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\Selects\MultiUserSelectMenu {
        return new Elements\Selects\MultiUserSelectMenu($actionId, $placeholder, $initialUsers, $maxSelectedItems, $confirm, $focusOnLoad);
    }

    public static function numberInput(
        ?string $actionId = null,
        ?bool $allowDecimal = null,
        int|float|string|null $maxValue = null,
        int|float|string|null $minValue = null,
        int|float|string|null $initialValue = null,
        Parts\PlainText|string|null $placeholder = null,
        ?bool $focusOnLoad = null,
        ?Parts\DispatchActionConfig $dispatchActionConfig = null,
    ): Elements\NumberInput {
        return new Elements\NumberInput($actionId, $allowDecimal, $maxValue, $minValue, $initialValue, $placeholder, $focusOnLoad, $dispatchActionConfig);
    }

    /**
     * @param Collections\OptionSet|array<Parts\Option|string>|array<string, string>|null $options
     */
    public static function overflowMenu(
        ?string $actionId = null,
        Collections\OptionSet|array|null $options = null,
        ?Parts\Confirm $confirm = null,
    ): Elements\OverflowMenu {
        return new Elements\OverflowMenu($actionId, $options, $confirm);
    }

    public static function plainTextInput(
        ?string $actionId = null,
        Parts\PlainText|string|null $placeholder = null,
        ?int $maxLength = null,
        ?int $minLength = null,
        ?bool $multiline = null,
        ?Parts\DispatchActionConfig $dispatchActionConfig = null,
        ?string $initialValue = null,
        ?bool $focusOnLoad = null,
    ): Elements\PlainTextInput {
        return new Elements\PlainTextInput($actionId, $placeholder, $maxLength, $minLength, $multiline, $dispatchActionConfig, $initialValue, $focusOnLoad);
    }

    /**
     * @param Collections\OptionSet|array<Parts\Option|string>|array<string, string>|null $options
     */
    public static function radioButtons(
        ?string $actionId = null,
        Collections\OptionSet|array|null $options = null,
        Parts\Option|null $initialOption = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\RadioButtons {
        return new Elements\RadioButtons($actionId, $options, $initialOption, $confirm, $focusOnLoad);
    }

    /**
     * @param Collections\RichTextSectionCollection|array<Collections\RichTextSectionCollection|Elements\RichTexts\RichTextSection|string|null> $elements
     *
     * @see https://api.slack.com/reference/block-kit/blocks#rich_text_list
     */
    public static function richTextList(
        Collections\RichTextSectionCollection|array $elements = [],
        Elements\RichTexts\ListStyle|string|null $style = null,
        ?int $indent = null,
        ?int $offset = null,
        ?int $border = null,
    ): Elements\RichTexts\RichTextList {
        return new Elements\RichTexts\RichTextList($elements, $style, $indent, $offset, $border);
    }

    /**
     * @param Collections\TextCollection|array<Collections\TextCollection|Elements\RichTexts\Text|string|null> $elements
     *
     * @see https://api.slack.com/reference/block-kit/blocks#rich_text_preformatted
     */
    public static function richTextPreformatted(
        Collections\TextCollection|array $elements = [],
        ?int $border = null,
    ): Elements\RichTexts\RichTextPreformatted {
        return new Elements\RichTexts\RichTextPreformatted($elements, $border);
    }

    /**
     * @param Collections\RichTextCollection|array<Collections\RichTextCollection|Elements\RichTexts\RichTextElement|string|null> $elements
     *
     * @see https://api.slack.com/reference/block-kit/blocks#rich_text_quote
     */
    public static function richTextQuote(
        Collections\RichTextCollection|array $elements = [],
        ?int $border = null,
    ): Elements\RichTexts\RichTextQuote {
        return new Elements\RichTexts\RichTextQuote($elements, $border);
    }

    /**
     * @param Collections\RichTextCollection|array<Collections\RichTextCollection|Elements\RichTexts\RichTextElement|string|null> $elements
     *
     * @see https://api.slack.com/reference/block-kit/blocks#rich_text_section
     */
    public static function richTextSection(
        Collections\RichTextCollection|array $elements = [],
    ): Elements\RichTexts\RichTextSection {
        return new Elements\RichTexts\RichTextSection($elements);
    }

    /**
     * @param Collections\OptionSet|array<Parts\Option|string>|array<string, string>|null $options
     * @param Collections\OptionGroupCollection|array<Parts\OptionGroup|null>|array<string, Collections\OptionSet|array<string, string>>|null $optionGroups
     */
    public static function staticSelectMenu(
        ?string $actionId = null,
        Parts\PlainText|string|null $placeholder = null,
        Collections\OptionSet|array|null $options = null,
        Collections\OptionGroupCollection|array|null $optionGroups = null,
        Parts\Option|string|null $initialOption = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\Selects\StaticSelectMenu {
        return new Elements\Selects\StaticSelectMenu($actionId, $placeholder, $options, $optionGroups, $initialOption, $confirm, $focusOnLoad);
    }

    /**
     * @see https://api.slack.com/reference/block-kit/blocks#text-element-type
     */
    public static function text(?string $text = null, ?Parts\Style $style = null): Elements\RichTexts\Text
    {
        return new Elements\RichTexts\Text($text, $style);
    }

    public static function timePicker(
        ?string $actionId = null,
        \DateTime|string|null $initialTime = null,
        ?string $placeholder = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\TimePicker {
        return new Elements\TimePicker($actionId, $initialTime, $placeholder, $confirm, $focusOnLoad);
    }

    /**
     * @see https://api.slack.com/reference/block-kit/blocks#user-element-type
     */
    public static function user(?string $userId = null, ?Parts\MentionStyle $style = null): Elements\RichTexts\User
    {
        return new Elements\RichTexts\User($userId, $style);
    }

    /**
     * @see https://api.slack.com/reference/block-kit/blocks#user-group-element-type
     */
    public static function usergroup(
        ?string $usergroupId = null,
        ?Parts\MentionStyle $style = null,
    ): Elements\RichTexts\Usergroup {
        return new Elements\RichTexts\Usergroup($usergroupId, $style);
    }

    public static function userSelectMenu(
        ?string $actionId = null,
        Parts\PlainText|string|null $placeholder = null,
        ?string $initialUser = null,
        ?Parts\Confirm $confirm = null,
        ?bool $focusOnLoad = null,
    ): Elements\Selects\UserSelectMenu {
        return new Elements\Selects\UserSelectMenu($actionId, $placeholder, $initialUser, $confirm, $focusOnLoad);
    }
    #endregion

    #region Parts
    public static function confirm(
        Parts\PlainText|string|null $title = null,
        Parts\Text|string|null $text = null,
        Parts\PlainText|string|null $confirm = 'OK',
        Parts\PlainText|string|null $deny = 'Cancel',
        Elements\ButtonStyle|string|null $style = null,
    ): Parts\Confirm {
        return new Parts\Confirm($title, $text, $confirm, $deny, $style);
    }

    /**
     * @param array<Parts\TriggerActionsOn|string|null> $triggerActionsOn
     */
    public static function dispatchActionConfig(array $triggerActionsOn = []): Parts\DispatchActionConfig
    {
        return new Parts\DispatchActionConfig($triggerActionsOn);
    }

    /**
     * @param iterable<string|Parts\Text>|array<string, string|Parts\Text>|null $fields
     */
    public static function fields(?iterable $fields = null): Parts\Fields
    {
        return new Parts\Fields($fields);
    }

    /**
     * @param iterable<string, string|Parts\Text> $map
     */
    public static function fieldsFromMap(iterable $map, bool $groupOutput = false): Parts\Fields
    {
        return Parts\Fields::fromMap($map, $groupOutput);
    }

    /**
     * @param iterable<string[]|Parts\Text[]> $pairs
     */
    public static function fieldsFromPairs(iterable $pairs, bool $groupOutput = false): Parts\Fields
    {
        return Parts\Fields::fromPairs($pairs, $groupOutput);
    }

    /**
     * @param array<Parts\ConversationType|string|null> $include
     */
    public static function filter(
        array $include = [],
        ?bool $excludeExternalSharedChannels = null,
        ?bool $excludeBotUsers = null,
    ): Parts\Filter {
        return new Parts\Filter($include, $excludeExternalSharedChannels, $excludeBotUsers);
    }

    public static function mentionStyle(
        ?bool $bold = null,
        ?bool $italic = null,
        ?bool $strike = null,
        ?bool $highlight = null,
        ?bool $clientHighlight = null,
        ?bool $unlink = null,
    ): Parts\MentionStyle {
        return new Parts\MentionStyle($bold, $italic, $strike, $highlight, $clientHighlight, $unlink);
    }

    public static function mrkdwnText(?string $text = null, ?bool $verbatim = null): Parts\MrkdwnText
    {
        return new Parts\MrkdwnText($text, $verbatim);
    }

    public static function option(
        Parts\PlainText|string|null $text = null,
        ?string $value = null,
        Parts\PlainText|string|null $description = null,
        ?string $url = null,
        ?bool $initial = null,
    ): Parts\Option {
        return new Parts\Option($text, $value, $description, $url, $initial);
    }

    public static function optionGroup(
        ?string $label = null,
        Collections\OptionSet|array|null $options = null,
    ): Parts\OptionGroup {
        return new Parts\OptionGroup($label, $options);
    }

    public static function plainText(?string $text = null, ?bool $emoji = null): Parts\PlainText
    {
        return new Parts\PlainText($text, $emoji);
    }

    public static function style(
        ?bool $bold = null,
        ?bool $italic = null,
        ?bool $strike = null,
        ?bool $code = null,
    ): Parts\Style {
        return new Parts\Style($bold, $italic, $strike, $code);
    }
    #endregion

    #region Collections
    /**
     * @param array<Elements\Button|Elements\Checkboxes|Elements\DatePicker|Elements\OverflowMenu|Elements\RadioButtons|Elements\Selects\SelectMenu|Elements\TimePicker|null> $actions
     */
    public static function actionCollection(array $actions = []): Collections\ActionCollection
    {
        return new Collections\ActionCollection($actions);
    }

    /**
     * @param array<Surfaces\Attachment|null> $attachments
     */
    public static function attachmentCollection(array $attachments = []): Collections\AttachmentCollection
    {
        return new Collections\AttachmentCollection($attachments);
    }

    /**
     * @param array<Blocks\Block|null> $blocks
     */
    public static function blockCollection(array $blocks = []): Collections\BlockCollection
    {
        return new Collections\BlockCollection($blocks);
    }

    /**
     * @param array<Elements\Image|Parts\Text|string|null> $elements
     */
    public static function contextCollection(array $elements = []): Collections\ContextCollection
    {
        return new Collections\ContextCollection($elements);
    }

    /**
     * @param array<Parts\OptionGroup|null>|array<string, Collections\OptionSet|array<string, string>> $optionGroups
     */
    public static function optionGroupCollection(array $optionGroups = []): Collections\OptionGroupCollection
    {
        return new Collections\OptionGroupCollection($optionGroups);
    }

    /**
     * @param array<Parts\Option|string|null>|array<string, string> $options
     */
    public static function optionSet(array $options = []): Collections\OptionSet
    {
        return new Collections\OptionSet($options);
    }

    /**
     * @param array<Elements\RichTexts\RichTextElement|Collections\RichTextCollection|string|null> $elements
     */
    public static function richTextCollection(array $elements = []): Collections\RichTextCollection
    {
        return new Collections\RichTextCollection($elements);
    }

    /**
     * @param array<Elements\RichTexts\RichTextSection|Collections\RichTextSectionCollection|string|null> $sections
     */
    public static function richTextSectionCollection(array $sections = []): Collections\RichTextSectionCollection
    {
        return new Collections\RichTextSectionCollection($sections);
    }

    /**
     * @param array<Elements\RichTexts\RichTextSubElement|Collections\RichTextSubCollection|null> $elements
     */
    public static function richTextSubCollection(array $elements = []): Collections\RichTextSubCollection
    {
        return new Collections\RichTextSubCollection($elements);
    }

    /**
     * @param array<Elements\RichTexts\Text|Collections\TextCollection|string|null> $elements
     */
    public static function textCollection(array $elements = []): Collections\TextCollection
    {
        return new Collections\TextCollection($elements);
    }
    #endregion

    #region Virtual blocks
    public static function codeBlock(
        ?string $code = null,
        ?string $caption = null,
        ?string $blockId = null,
    ): Blocks\Virtual\CodeBlock {
        return new Blocks\Virtual\CodeBlock($code, $caption, $blockId);
    }

    /**
     * @param array<string[]>|array<string, string>|null $rows
     * @param array<string>|null $cols
     */
    public static function twoColumnTable(
        ?array $rows = null,
        ?array $cols = null,
        ?bool $borders = null,
        ?string $blockId = null,
    ): Blocks\Virtual\TwoColumnTable {
        return new Blocks\Virtual\TwoColumnTable($rows, $cols, $borders, $blockId);
    }
    #endregion

    #region Other tools and helpers
    public static function md(): Md
    {
        return new Md();
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function privateMetadata(array $data = []): PrivateMetadata
    {
        return new PrivateMetadata($data);
    }

    public static function preview(Surfaces\Surface $surface): string
    {
        return Previewer::new()->preview($surface);
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function hydrate(array $data, ?Type $type = null): Component
    {
        if ($type) {
            $data['type'] = $type->value;
        }

        return Component::fromArray($data);
    }
    #endregion
}
