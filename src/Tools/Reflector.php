<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tools;

use ReflectionClass;
use ReflectionProperty;
use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Tools\Validation\PropertyRule;
use SlackPhp\BlockKit\Tools\Validation\RequirementRule;
use SlackPhp\BlockKit\FauxProperty;
use SlackPhp\BlockKit\Property;

final class Reflector
{
    private const INCLUDE_CHILDREN = 2;

    private static array $classes = [];

    public static function component(Component|string $class): ReflectionClass
    {
        if ($class instanceof Component) {
            $class = get_class($class);
        }

        self::$classes[$class] ??= new ReflectionClass($class);

        return self::$classes[$class];
    }

    public static function propertyAttribute(ReflectionProperty $classProperty): ?Property
    {
        /** @var ?Property $property */
        $property = null;

        foreach ($classProperty->getAttributes(Property::class) as $attribute) {
            $property = $attribute->newInstance();
            break;
        }

        return $property;
    }

    public static function fauxPropertyAttribute(ReflectionProperty $classProperty): ?FauxProperty
    {
        /** @var ?FauxProperty $property */
        $property = null;

        foreach ($classProperty->getAttributes(FauxProperty::class) as $attribute) {
            $property = $attribute->newInstance();
            break;
        }

        return $property;
    }

    /**
     * @return array<RequirementRule>
     */
    public static function requirementRules(ReflectionClass $class): array
    {
        $rules = [];
        foreach ($class->getAttributes(RequirementRule::class, self::INCLUDE_CHILDREN) as $attribute) {
            $rules[] = $attribute->newInstance();
        }

        return $rules;
    }

    /**
     * @return array<PropertyRule>
     */
    public static function propertyRules(ReflectionProperty $property): array
    {
        $rules = [];
        foreach ($property->getAttributes(PropertyRule::class, self::INCLUDE_CHILDREN) as $attribute) {
            $rules[] = $attribute->newInstance();
        }

        return $rules;
    }
}
