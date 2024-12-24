<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\Traits\HasMentionStyle;
use SlackPhp\BlockKit\Parts\MentionStyle;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;
use SlackPhp\BlockKit\Validation\ValidString;

/**
 * @see https://api.slack.com/reference/block-kit/blocks#user-element-type
 */
#[RequiresAllOf('user_id')]
class User extends RichTextElement
{
    use HasMentionStyle;

    #[Property('user_id'), ValidString]
    public ?string $userId;

    public function __construct(?string $userId = null, ?MentionStyle $style = null)
    {
        parent::__construct();
        $this->userId($userId);
        $this->style($style);
    }

    public function userId(?string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
