<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Validation;

use Attribute;
use SlackPhp\BlockKit\Component;

#[Attribute(Attribute::TARGET_CLASS)]
class RequiresAllOf extends RequirementRule
{
    public function check(Component $component): void
    {
        foreach ($this->fields as $field) {
            if (!$this->hasValue($field)) {
                throw new ValidationException(
                    'A valid "%s" component requires that ALL of these fields are present: %s',
                    [$component->type->value, $this->fieldList()],
                );
            }
        }
    }
}
