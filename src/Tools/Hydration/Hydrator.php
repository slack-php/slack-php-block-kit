<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tools\Hydration;

use Closure;
use ReflectionProperty;
use SlackPhp\BlockKit\Collections\ComponentCollection;
use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\FauxProperty;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Reflector;
use SlackPhp\BlockKit\Type;

class Hydrator
{
    /** @var array<string, mixed> */
    private array $data;

    /** @var array<string, bool> */
    private array $consumed = [];

    public readonly Component $component;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data, ?string $initiatingClass = null)
    {
        $this->data = $data;
        $this->component = $this->initComponent($initiatingClass);
    }

    private function initComponent(?string $initiatingClass): Component
    {
        $type = Type::fromValue($this->useValue('type'));

        $class = $type?->toClass() ?? $initiatingClass;
        if ($class === null) {
            throw new HydrationException('The class to hydrate could not be determine.');
        }

        $reflection = Reflector::component($class);
        if ($reflection->isAbstract() || !$reflection->isSubclassOf(Component::class)) {
            throw new HydrationException('Class %s is abstract or is not a Component', [$reflection->getShortName()]);
        }

        /** @var Component $component */
        $component = $reflection->newInstance();

        return $component;
    }

    public function getComponent(): Component
    {
        try {
            $class = Reflector::component($this->component);

            foreach ($class->getProperties() as $classProperty) {
                $property = Reflector::propertyAttribute($classProperty);
                $fauxProperty = Reflector::fauxPropertyAttribute($classProperty);

                if ($property || $fauxProperty) {
                    $setter = $class->getMethod($classProperty->getName())->getClosure($this->component);
                    if ($property) {
                        $this->setProperty($classProperty, $property, $setter);
                    } else {
                        $this->setFauxProperty($fauxProperty, $setter);
                    }
                }
            }

            $this->component->extra(array_diff_key($this->data, $this->consumed));

            return $this->component;
        } catch (\Throwable $ex) {
            throw new HydrationException($ex->getMessage(), [], $ex);
        }
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
            $setValue(array_map(fn(array $value) => Component::fromArray($value), $this->useComponents(null)));
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
    private function useArray(?string $key): array
    {
        if ($key === null) {
            $this->consumed += array_fill_keys(array_keys($this->data), true);

            return array_values($this->data);
        }

        $this->consumed[$key] = true;

        return $this->data[$key] ?? [];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function useComponents(?string $key): array
    {
        return $this->useArray($key);
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
