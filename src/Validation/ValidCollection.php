<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Validation;

use Attribute;
use SlackPhp\BlockKit\Component;

use function is_countable;
use function is_iterable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ValidCollection implements PropertyRule
{
    public function __construct(
        private int $maxCount = 0,
        private int $minCount = 1,
    ) {}

    public function check(Component $component, string $field, mixed $value): void
    {
        if ($value === null) {
            return;
        }

        $collection = $value;
        if (!is_countable($collection) || !is_iterable($collection)) {
            throw new ValidationException(
                'The "%s" field of a valid "%s" component must be iterable and countable',
                [$field, $component->type->value],
            );
        }

        if (count($collection) === 0) {
            return;
        }

        if (count($collection) < $this->minCount) {
            throw new ValidationException(
                'The "%s" field of a valid "%s" component must have AT LEAST %d items',
                [$field, $component->type->value, $this->minCount],
            );
        }

        if ($this->maxCount > 0 && count($collection) > $this->maxCount) {
            throw new ValidationException(
                'The "%s" field of a valid "%s" component must NOT EXCEED %d items',
                [$field, $component->type->value, $this->maxCount],
            );
        }
    }
}
