<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Hydration;

use Closure;
use ReflectionProperty;
use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Collections\ComponentCollection;
use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\FauxProperty;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Reflector;
use SlackPhp\BlockKit\Type;
use Throwable;

class Hydrator
{
    /** @var array<string, bool> */
    private array $consumed = [];

    public static function forJson(string $json): self
    {
        try {
            return new self(json_decode($json, true, 512, JSON_THROW_ON_ERROR));
        } catch (Throwable $err) {
            throw new HydrationException('JSON error hydrating component', [], $err);
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(private array $data)
    {}

    /**
     * @param class-string $targetClass
     */
    public function getComponent(string $targetClass): Component
    {
        try {
            $component = $this->initComponent($targetClass);
            $this->fillComponent($component);
            return $component;
        } catch (HydrationException $ex) {
            throw $ex;
        } catch (Throwable $ex) {
            throw new HydrationException($ex->getMessage(), [], $ex);
        }
    }

    /**
     * @param class-string $targetClass
     */
    private function initComponent(string $targetClass): Component
    {
        $type = Type::fromValue($this->useValue('type'));

        // Since the "image" type is used in Slack as both a Block and Element type, we have to map an image component
        // in a surface context to a different type in order to resolve it to the BlockImage class. The reverse logic
        // for dehydration is handled by the BlockImage's `AliasType` attribute.
        if ($type === Type::IMAGE && $targetClass === Block::class) {
            $type = Type::BLOCK_IMAGE;
        }

        $typeClass = $type?->toClass() ?? $targetClass;

        if (!is_a($typeClass, Component::class, true)) {
            throw new HydrationException('Class %s not a Component class', [$typeClass]);
        }

        if (!is_a($typeClass, $targetClass, true)) {
            throw new HydrationException('Class %s is not a subclass of %s', [$typeClass, $targetClass]);
        }

        $reflection = Reflector::component($typeClass);

        if ($reflection->isAbstract()) {
            throw new HydrationException('Class %s is abstract and cannot be instantiated', [$reflection->getName()]);
        }

        /** @var Component $component */
        $component = $reflection->newInstance();

        return $component;
    }

    private function fillComponent(Component $component): void
    {
        $class = Reflector::component($component);

        foreach ($class->getProperties() as $classProperty) {
            $property = Reflector::propertyAttribute($classProperty);
            $fauxProperty = Reflector::fauxPropertyAttribute($classProperty);

            if ($property || $fauxProperty) {
                $setter = $class->getMethod($classProperty->getName())->getClosure($component);
                if ($property) {
                    $this->setProperty($classProperty, $property, $setter);
                } else {
                    $this->setFauxProperty($fauxProperty, $setter);
                }
            }
        }

        $component->extra(array_diff_key($this->data, $this->consumed));
    }

    private function setProperty(ReflectionProperty $reflection, Property $property, Closure $setValue): void
    {
        $field = $property->field ?? $reflection->getName();
        $propType = $reflection->getType()->getName();

        if (is_a($propType, Component::class, true)) {
            $factory = [$propType, 'fromArray'](...);
            $setValue($factory($this->useComponent($field)));
        } elseif (is_a($propType, ComponentCollection::class, true)) {
            $factory = [$propType, 'fromArray'](...);
            $setValue($factory($this->useArray($field)));
        } elseif ($property->spread) {
            $setValue(...$this->useArray($field));
        } else {
            $setValue($this->useValue($field));
        }
    }

    private function setFauxProperty(FauxProperty $property, Closure $setValue): void
    {
        if ($property->fields === ['*']) {
            $setValue(array_map(fn(array $value) => Component::fromArray($value), $this->useAllAsArray()));
        } else {
            $setValue($this->useValues(...$property->fields));
        }
    }

    private function useValue(string $key): mixed
    {
        $this->consumed[$key] = true;

        return $this->data[$key] ?? null;
    }

    /**
     * @return array<string, mixed>
     */
    private function useValues(string ...$keys): array
    {
        $values = [];
        foreach ($keys as $key) {
            $this->consumed[$key] = true;
            $values[$key] = $this->data[$key] ?? null;
        }

        return $values;
    }

    /**
     * @return array<int, mixed>
     */
    private function useArray(string $key): array
    {
        $this->consumed[$key] = true;

        return $this->data[$key] ?? [];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function useAllAsArray(): array
    {
        $this->consumed += array_fill_keys(array_keys($this->data), true);

        return array_values($this->data);
    }

    /**
     * @return array<string, mixed>|null
     */
    private function useComponent(string $key): ?array
    {
        $this->consumed[$key] = true;

        return $this->data[$key] ?? null;
    }
}
