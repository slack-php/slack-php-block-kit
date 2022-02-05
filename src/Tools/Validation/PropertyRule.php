<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tools\Validation;

use SlackPhp\BlockKit\Component;

interface PropertyRule
{
    public function check(Component $component, string $field, mixed $value): void;
}
