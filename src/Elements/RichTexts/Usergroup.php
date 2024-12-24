<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\Traits\HasMentionStyle;
use SlackPhp\BlockKit\Parts\MentionStyle;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;
use SlackPhp\BlockKit\Validation\ValidString;

/**
 * @see https://api.slack.com/reference/block-kit/blocks#user-group-element-type
 */
#[RequiresAllOf('usergroup_id')]
class Usergroup extends RichTextElement
{
    use HasMentionStyle;

    #[Property('usergroup_id'), ValidString]
    public ?string $usergroupId = null;

    public function __construct(?string $usergroupId = null, ?MentionStyle $style = null)
    {
        parent::__construct();
        $this->usergroupId($usergroupId);
        $this->style($style);
    }

    public function usergroupId(?string $usergroupId): self
    {
        $this->usergroupId = $usergroupId;

        return $this;
    }
}
