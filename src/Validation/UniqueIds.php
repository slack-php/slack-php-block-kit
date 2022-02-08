<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Validation;

use Attribute;
use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Elements\Element;

use function is_iterable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class UniqueIds implements PropertyRule
{
    public function check(Component $component, string $field, mixed $value): void
    {
        if (!is_iterable($value)) {
            return;
        }

        $uniqueIds = [];
        foreach ($value as $item) {
            if ($item instanceof Block) {
                $idField = 'block_id';
                $idValue = $item->blockId;
            } elseif ($item instanceof Element && isset($item->actionId)) {
                $idField = 'action_id';
                $idValue = $item->actionId;
            }

            if (!isset($idField, $idValue)) {
                continue;
            }

            if (in_array($idValue, $uniqueIds, true)) {
                throw new ValidationException(
                    'The "%s" field of a valid "%s" component must NOT have any items with duplicate "%s"s',
                    [$field, $component->type->value, $idField],
                );
            } else {
                $uniqueIds[] = $idValue;
            }
        }
    }
}
