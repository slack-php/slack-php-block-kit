<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FauxProperty
{
    /** @var array<string> */
    public readonly array $fields;

    public function __construct(string ...$fields)
    {
        $this->fields = $fields;
    }
}
