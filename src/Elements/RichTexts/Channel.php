<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\Traits\HasMentionStyle;
use SlackPhp\BlockKit\Parts\MentionStyle;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;
use SlackPhp\BlockKit\Validation\ValidString;

/**
 * @see https://api.slack.com/reference/block-kit/blocks#channel-element-type
 */
#[RequiresAllOf('channel_id')]
class Channel extends RichTextElement
{
    use HasMentionStyle;

    #[Property('channel_id'), ValidString]
    public ?string $channelId;

    public function __construct(?string $channelId = null, ?MentionStyle $style = null)
    {
        parent::__construct();

        $this->channelId($channelId);
        $this->style($style);
    }

    public function channelId(?string $channelId): self
    {
        $this->channelId = $channelId;

        return $this;
    }
}
