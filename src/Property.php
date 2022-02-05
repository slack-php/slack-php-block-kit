<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Property
{
    public function __construct(
        public readonly ?string $field = null,
        public readonly bool $spread = false,
    ) {}
}
