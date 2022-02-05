<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tools\Validation;

use function is_countable;

abstract class RequirementRule implements ComponentRule
{
    /** @var array<string>  */
    protected array $fields;
    /** @var array<string, mixed>  */
    protected array $tracked = [];

    public function __construct(string ...$fields)
    {
        $this->fields = $fields;
    }

    public function track(string $field, mixed $value): void
    {
        $this->tracked[$field] = $value;
    }

    protected function fieldList(): string
    {
        return implode(', ', array_map(fn (string $field) => "\"{$field}\"", $this->fields));
    }

    protected function hasValue(string $field): bool
    {
        $value = $this->tracked[$field] ?? null;

        if ($value === null) {
            return false;
        }

        if (is_countable($value)) {
            return count($value) > 0;
        }

        return true;
    }
}
