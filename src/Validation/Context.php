<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Validation;

use SlackPhp\BlockKit\Component;

class Context
{
    public function __construct(
        /** @var array<string> */
        private array $segments = [],
    ) {
    }

    public function add(Component $component): void
    {
        $segment = $component->type->value;
        $id = $this->getId($component);
        $segment .= $id ? " {id: {$id}}" : '';

        $this->segments[] = $segment;
    }

    public function addIndex(int $index): void
    {
        $this->segments[] = "[{$index}]";
    }

    public function __toString(): string
    {
        return implode(' > ', $this->segments);
    }

    private function getId(Component $component): ?string
    {
        if (isset($component->blockId)) {
            return $component->blockId;
        }

        if (isset($component->actionId)) {
            return $component->actionId;
        }

        return null;
    }
}
