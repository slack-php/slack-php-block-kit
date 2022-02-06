<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Validation;

use Attribute;
use SlackPhp\BlockKit\Component;

#[Attribute(Attribute::TARGET_CLASS)]
class RequiresOneOf extends RequirementRule
{
    public function check(Component $component): void
    {
        $valid = false;
        foreach ($this->fields as $field) {
            if ($this->hasValue($field)) {
                if ($valid) {
                    $valid = false;
                    break;
                } else {
                    $valid = true;
                }
            }
        }

        if (!$valid) {
            throw new ValidationException(
                'A valid "%s" component requires that ONLY ONE of these fields is present: %s',
                [$component->type->value, $this->fieldList()],
            );
        }
    }
}
