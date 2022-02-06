<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Validation;

use Attribute;
use SlackPhp\BlockKit\Component;

#[Attribute(Attribute::TARGET_CLASS)]
class RequiresAnyOf extends RequirementRule
{
    public function check(Component $component): void
    {
        foreach ($this->fields as $field) {
            if ($this->hasValue($field)) {
                return;
            }
        }

        throw new ValidationException(
            'A valid "%s" component requires that ONE OR MORE of these fields are present: %s',
            [$component->type->value, $this->fieldList()],
        );
    }
}
