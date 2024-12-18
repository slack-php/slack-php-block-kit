<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\Element;
use SlackPhp\BlockKit\Validation\RequiresAllOf;

#[RequiresAllOf('elements')]
abstract class RichTextSubElement extends Element
{
}
