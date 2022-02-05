<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tools\Validation;

use Attribute;
use DateTime;
use SlackPhp\BlockKit\Component;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ValidDatetime implements PropertyRule
{
    public function __construct(
        private string $phpFormat,
        private string $humanFormat,
    ) {}

    public function check(Component $component, string $field, mixed $value): void
    {
        if ($value === null) {
            return;
        }

        $dt = DateTime::createFromFormat($this->phpFormat, $value);
        if (!$dt) {
            throw new ValidationException(
                'The date-time "%s" field of a valid "%s" component must follow the following format: %s',
                [$field, $component->type->value, $this->humanFormat],
            );
        }
    }
}
