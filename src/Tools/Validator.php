<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tools;

use DateTime;
use SlackPhp\BlockKit\Collections\ComponentCollection;
use SlackPhp\BlockKit\Component;

use function is_countable;
use function str_contains;

final class Validator
{
    /** @var array<string> */
    public readonly array $context;

    /**
     * @param Component $component
     * @param array<string> $context
     */
    public function __construct(public readonly Component $component, array $context = [])
    {
        if (isset($this->component->blockId)) {
            $id = $this->component->blockId;
        } elseif (isset($this->component->actionId)) {
            $id = $this->component->actionId;
        } else {
            $id = null;
        }

        $newContextValue = $this->component->type->value . ($id ? " <{$id}>" : '');
        $this->context = [...$context, $newContextValue];
    }

    public function requireAllOf(string ...$fields): self
    {
        $fields = $this->prepareFields($fields);
        foreach ($fields as $property) {
            $value = $this->value($property);
            if (!$this->isPresent($value)) {
                throw new ValidationException(
                    'A valid "%s" component requires that ALL of these fields are present: %s',
                    [$this->component->type->value, $this->fieldList($fields)],
                    $this->context,
                );
            }
        }

        return $this;
    }

    public function requireSomeOf(string ...$fields): self
    {
        $valid = false;
        $fields = $this->prepareFields($fields);
        foreach ($fields as $property) {
            $value = $this->value($property);
            if ($this->isPresent($value)) {
                $valid = true;
                break;
            }
        }

        if (!$valid) {
            throw new ValidationException(
                'A valid "%s" component requires that ONE OR MORE of these fields are present: %s',
                [$this->component->type->value, $this->fieldList($fields)],
                $this->context,
            );
        }

        return $this;
    }

    public function requireOneOf(string ...$fields): self
    {
        $valid = false;
        $fields = $this->prepareFields($fields);
        foreach ($fields as $property) {
            $value = $this->value($property);
            if ($this->isPresent($value)) {
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
                [$this->component->type->value, $this->fieldList($fields)],
                $this->context,
            );
        }

        return $this;
    }

    public function preventAllOf(string ...$fields): self
    {
        $fields = $this->prepareFields($fields);
        foreach ($fields as $property) {
            if ($this->value($property) !== null) {
                throw new ValidationException(
                    'A valid "%s" component in this context requires that NONE of these fields are present: %s',
                    [$this->component->type->value, $this->fieldList($fields)],
                    $this->context,
                );
            }
        }

        return $this;
    }

    public function validateSubComponents(string ...$fields): self
    {
        foreach ($this->prepareFields($fields) as $property) {
            $value = $this->value($property);
            if ($value instanceof Component) {
                $value->validate($this->context);
            }
        }

        return $this;
    }

    public function validateString(string $field, int $max = 0, int $min = 1): self
    {
        $property = $this->camelCase($field);
        $value = $this->value($property);
        if ($value === null) {
            return $this;
        }

        $text = (string) $value;
        if ($this->strlen($text) < $min) {
            throw new ValidationException(
                'The "%s" field of a valid "%s" component must be AT LEAST %d character(s) in length',
                [$field, $this->component->type->value, $min],
                $this->context,
            );
        }

        if ($max > 0 && $this->strlen($text) > $max) {
            throw new ValidationException(
                'The "%s" field of a valid "%s" component must NOT EXCEED %d characters in length',
                [$field, $this->component->type->value, $max],
                $this->context,
            );
        }

        return $this;
    }

    public function validateInt(string $field, int $max = 0, int $min = 1): self
    {
        $property = $this->camelCase($field);
        $value = $this->value($property);
        if ($value === null) {
            return $this;
        }

        $num = (int) $value;
        if ($num < $min) {
            throw new ValidationException(
                'The numeric "%s" field of a valid "%s" component must be GREATER THAN %d',
                [$field, $this->component->type->value, $min],
                $this->context,
            );
        }

        if ($max > 0 && $num > $max) {
            throw new ValidationException(
                'The numeric "%s" field of a valid "%s" component must be LESS THAN %d',
                [$field, $this->component->type->value, $max],
                $this->context,
            );
        }

        return $this;
    }

    public function validateDatetime(string $field, string $phpFormat, string $errFormat): self
    {
        $property = $this->camelCase($field);
        $value = $this->value($property);
        if ($value === null) {
            return $this;
        }

        $dt = DateTime::createFromFormat($phpFormat, $value);
        if (!$dt) {
            throw new ValidationException(
                'The date-time "%s" field of a valid "%s" component must follow the following format: %s',
                [$field, $this->component->type->value, $errFormat],
                $this->context,
            );
        }

        return $this;
    }

    public function validateCollection(string $field, int $max = 0, int $min = 1, bool $validateIds = false): self
    {
        $property = $this->camelCase($field);
        $collection = $this->value($property);
        if (!$this->isPresent($collection)) {
            return $this;
        } elseif (!is_countable($collection) || !is_iterable($collection)) {
            throw new ValidationException(
                'The "%s" field of a valid "%s" component must be iterable and countable',
                [$field, $this->component->type->value],
                $this->context,
            );
        }

        if (count($collection) < $min) {
            throw new ValidationException(
                'The "%s" field of a valid "%s" component must have AT LEAST %d items',
                [$field, $this->component->type->value, $min],
                $this->context,
            );
        }

        if ($max > 0 && count($collection) > $max) {
            throw new ValidationException(
                'The "%s" field of a valid "%s" component must NOT EXCEED %d items',
                [$field, $this->component->type->value, $max],
                $this->context,
            );
        }

        if ($validateIds) {
            $collection = $this->useItemIdValidation($field, $collection);
        }

        foreach ($collection as $index => $item) {
            if ($item instanceof Component) {
                $item->validate([...$this->context, "[{$index}]"]);
            }
        }

        return $this;
    }

    /**
     * @param array<string|int> $args
     * @return $this
     */
    public function preventCondition(bool $condition, string $message, array $args = []): self
    {
        if ($condition) {
            throw new ValidationException($message, $args, $this->context);
        }

        return $this;
    }

    private function value(string $property): ComponentCollection|Component|array|string|int|bool|null
    {
        return $this->component->{$property} ?? null;
    }

    private function isPresent(mixed $value): bool
    {
        if ($value === null) {
            return false;
        }

        if (is_countable($value)) {
            return count($value) > 0;
        }

        return true;
    }

    private function camelCase(string $str): string
    {
        if (!str_contains($str, '_')) {
            return $str;
        }

        $words = array_map('ucfirst', explode('_', $str));

        return lcfirst(implode('', $words));
    }

    /**
     * @param array<string> $fields
     * @return array<string, string>
     */
    private function prepareFields(array $fields): array
    {
        return array_combine($fields, array_map($this->camelCase(...), $fields));
    }

    /**
     * @param array<string> $fields
     * @return string
     */
    private function fieldList(array $fields): string
    {
        if (!array_is_list($fields)) {
            $fields = array_keys($fields);
        }

        return implode(', ', array_map(fn (string $field) => "\"{$field}\"", $fields));
    }

    private function strlen(string $str): int
    {
        static $mbSupported = null;
        if ($mbSupported === null) {
            $mbSupported = function_exists('mb_strlen');
        }

        return $mbSupported ? mb_strlen($str, 'UTF-8') : strlen($str);
    }

    /**
     * @param mixed $item
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

    private function useItemIdValidation(string $field, iterable $items): iterable
    {
        $ids = [];
        foreach ($items as $index => $item) {
            yield $index => $item;

            ['field' => $idField, 'value' => $id] = $this->extractId($item);
            if (!empty($id)) {
                if (in_array($id, $ids, true)) {
                    throw new ValidationException(
                        'The "%s" field of a valid "%s" component must NOT have any items with duplicate "%s"s',
                        [$field, $this->component->type->value, $idField],
                        [...$this->context, "{$item->type->value} <{$id}>"],
                    );
                } else {
                    $ids[] = $id;
                }
            }
        }
    }
}
