<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Validation;

use Attribute;
use SlackPhp\BlockKit\Component;

#[Attribute(Attribute::TARGET_CLASS)]
class PreventAllOf extends RequirementRule
{
    public function check(Component $component): void
    {
        foreach ($this->fields as $field) {
            if ($this->hasValue($field)) {
                throw new ValidationException(
                    'A valid "%s" component in this context requires that NONE of these fields are present: %s',
                    [$component->type->value, $this->fieldList()],
                );
            }
        }
    }
}
