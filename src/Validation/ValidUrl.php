<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Validation;

use Attribute;
use SlackPhp\BlockKit\Component;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ValidUrl implements PropertyRule
{
    public function check(Component $component, string $field, mixed $value): void
    {
        if ($value === null) {
            return;
        }

        if (! \is_string($value) || filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new ValidationException(
                'The "%s" field of a valid "%s" component must be a valid URL',
                [$field, $component->type->value],
            );
        }
    }
}
