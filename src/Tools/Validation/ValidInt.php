<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tools\Validation;

use Attribute;
use SlackPhp\BlockKit\Component;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ValidInt implements PropertyRule
{
    public function __construct(
        private int $max = 0,
        private int $min = 1,
    ) {}

    public function check(Component $component, string $field, mixed $value): void
    {
        if ($value === null) {
            return;
        }

        $num = (int) $value;
        if ($num < $this->min) {
            throw new ValidationException(
                'The numeric "%s" field of a valid "%s" component must be GREATER THAN %d',
                [$field, $component->type->value, $this->min],
            );
        }

        if ($this->max > 0 && $num > $this->max) {
            throw new ValidationException(
                'The numeric "%s" field of a valid "%s" component must be LESS THAN %d',
                [$field, $component->type->value, $this->max],
            );
        }
    }
}
