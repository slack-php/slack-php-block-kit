<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit;

use JsonSerializable;
use ReflectionClass;
use SlackPhp\BlockKit\Enums\Type;
use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Tools\HydrationException;
use SlackPhp\BlockKit\Tools\Validator;
use Throwable;

abstract class Component implements JsonSerializable
{
    /** @var array<string, mixed> */
    protected array $extra;
    public readonly Type $type;

    public function __construct()
    {
        $this->extra = [];
        $this->type = Type::fromClass(static::class);
    }

    final public static function new(): static
    {
        return new static();
    }

    /**
     * Allows setting arbitrary extra fields on an element.
     *
     * @param array<string, mixed> $extra
     */
    final public function extra(array $extra): static
    {
        $this->extra = [...$this->extra, ...$extra];

        return $this;
    }

    /**
     * Allows you to "tap" into the fluent syntax with a callable.
     *
     *     $element = Elem::new()
     *         ->foo('bar')
     *         ->tap(function (Elem $elem) {
     *             $elem->newSubElem()->fizz('buzz');
     *         });
     */
    final public function tap(callable $tap): static
    {
        $tap($this);

        return $this;
    }

    /**
     * @throws Exception if the block kit item is invalid (e.g., missing data).
     */
    final public function validate(array $context = []): void
    {
        $this->validateInternalData(new Validator($this, $context));
    }

    final public function toArray(): array
    {
        return array_filter(
            [
                'type' => $this->type->toSlackValue(),
                ...$this->prepareArrayData(),
                ...array_map(fn (mixed $val) => $val instanceof Component ? $val->toArray() : $val, $this->extra),
            ],
            fn (mixed $value) => $value !== null && $value !== [],
        );
    }

    final public function toJson(bool $prettyPrint = false): string
    {
        $opts = JSON_THROW_ON_ERROR;
        if ($prettyPrint) {
            $opts |= JSON_PRETTY_PRINT;
        }

        return (string) json_encode($this, $opts);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    final public static function fromJson(string $json): static
    {
        try {
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $err) {
            throw new HydrationException('JSON error (%s) hydrating %s', [$err->getMessage(), static::class], $err);
        }

        return static::fromArray($data);
    }

    public static function fromArray(?array $data): ?static
    {
        if ($data === null) {
            return null;
        }

        try {
            $data = new HydrationData($data);
            $type = $data->type();
            $class = new ReflectionClass($type?->toClass() ?? static::class);
            if ($class->isAbstract() || !$class->isSubclassOf(Component::class)) {
                throw new Exception('Class %s is abstract or is not a Component', [$class->getShortName()]);
            }

            /** @var static $component */
            $component = $class->newInstance();
            $component->hydrateFromArrayData($data);
            return $component;
        } catch (Throwable $ex) {
            throw new HydrationException($ex->getMessage(), [], $ex);
        }
    }

    /**
     * @internal Used by fromArray implementations.
     */
    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $type = $data->type();
        $class = get_class($this);
        if ($type && $type->toClass() !== $class) {
            throw new Exception('Type %s does not map to class %s.', [$type->value, $class]);
        }

        $this->extra($data->getExtra());
    }

    /**
     * @internal Used by validate implementations.
     */
    protected function validateInternalData(Validator $validator): void
    {
        return;
    }

    /**
     * @internal Used by toArray implementations.
     */
    protected function prepareArrayData(): array
    {
        return [];
    }
}
