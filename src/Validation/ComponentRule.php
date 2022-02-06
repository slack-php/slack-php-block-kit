<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Validation;

use SlackPhp\BlockKit\Component;

interface ComponentRule
{
    public function check(Component $component): void;
}
