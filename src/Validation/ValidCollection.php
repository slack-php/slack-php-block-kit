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
        private bool $uniqueIds = false,
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

        if (!$this->uniqueIds) {
            return;
        }

        $uniqueIds = [];
        foreach ($collection as $item) {
            ['field' => $idField, 'value' => $idValue] = $this->extractId($item);
            if (!empty($idValue)) {
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

    /**
     * @return array{field: ?string, value: ?string}
     */
    private function extractId(mixed $item): array
    {
        if (!$item instanceof Component) {
            return ['field' => null, 'value' => null];
        }

        if (isset($item->blockId)) {
            return ['field' => 'block_id' , 'value' => $item->blockId];
        }

        if (isset($item->actionId)) {
            return ['field' => 'action_id', 'value' => $item->actionId];
        }

        return ['field' => null, 'value' => null];
    }
}
