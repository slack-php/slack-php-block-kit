<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Hydration;

use Attribute;
use SlackPhp\BlockKit\Type;

#[Attribute(Attribute::TARGET_CLASS)]
class AliasType
{
    public function __construct(public readonly ?Type $type = null)
    {
    }
}
