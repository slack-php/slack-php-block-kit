<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tools\Hydration;

use BackedEnum;
use ReflectionClass;
use SlackPhp\BlockKit\Collections\ComponentCollection;
use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Tools\Reflector;

class Dehydrator
{
    public function __construct(
        private Component $component
    ) {}

    public function getArrayData(): array
    {
        $data = [];

        $class = Reflector::component(get_class($this->component));

        // Handle the type.
        $type = $this->getType($class);
        if ($type) {
            $data['type'] = $type;
        }

        // Handle all other properties.
        foreach ($this->getProperties($class) as $key => $value) {
            $data[$key] = $value;
        }

        // Handle any provided extra fields.
        foreach ($this->component->extra as $key => $value) {
            $data[$key] = $value instanceof Component ? $value->toArray() : $value;
        }

        return $data;
    }

    private function getType(ReflectionClass $class): ?string
    {
        foreach ($class->getAttributes() as $attribute) {
            $typeAttr = $attribute->newInstance();
            if ($typeAttr instanceof OmitType) {
                return null;
            } elseif ($typeAttr instanceof AliasType) {
                return $typeAttr->type->value;
            }
        }

        return $this->component->type->value;
    }

    /**
     * @return iterable<string, mixed>
     */
    private function getProperties(ReflectionClass $class): iterable
    {
        foreach ($class->getProperties() as $classProperty) {
            $value = $classProperty->getValue($this->component);

            // Skip null values.
            if ($value === null) {
                continue;
            }

            // Handle regular properties.
            $property = Reflector::propertyAttribute($classProperty);
            if ($property !== null) {
                $field = $property->field ?? $classProperty->getName();
                $value = $this->resolveValue($value);
                if ($value !== null) {
                    yield $field => $value;
                }
                continue;
            }

            // Handle faux properties.
            $fauxProperty = Reflector::fauxPropertyAttribute($classProperty);
            if ($fauxProperty !== null) {
                yield from is_array($value) ? $value : $value->toArray();
            }
        }
    }

    private function resolveValue(mixed $value): mixed
    {
        if ($value instanceof Component || $value instanceof ComponentCollection) {
            return $value->toArray() ?: null;
        }

        if ($value instanceof BackedEnum) {
            return $value->value;
        }

        if (is_array($value)) {
            return array_map($this->resolveValue(...), $value);
        }

        return $value;
    }
}
