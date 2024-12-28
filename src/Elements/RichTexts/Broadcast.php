<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;

/**
 * @see https://api.slack.com/reference/block-kit/blocks#broadcast-element-type
 */
#[RequiresAllOf('range')]
class Broadcast extends RichTextElement
{
    #[Property]
    public ?Range $range;

    public function __construct(Range|string|null $range = null)
    {
        parent::__construct();
        $this->range($range);
    }

    public function range(Range|string|null $range): self
    {
        $this->range = Range::fromValue($range);

        return $this;
    }
}
