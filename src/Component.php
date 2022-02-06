<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit;

use JsonSerializable;
use SlackPhp\BlockKit\Hydration\{Dehydrator, Hydrator};
use SlackPhp\BlockKit\Validation\{Context, Validator};

abstract class Component implements JsonSerializable
{
    /** @var array<string, mixed> */
    public array $extra;
    public readonly Type $type;
    public readonly Validator $validator;

    public function __construct()
    {
        $this->extra = [];
        $this->type = Type::fromClass(static::class);
        $this->validator = new Validator($this);
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

    final public function validate(?Context $context = null): void
    {
        $this->validator->validate($context);
    }

    /**
     * @return array<string, mixed>
     */
    final public function toArray(): array
    {
        $dehydrator = new Dehydrator($this);

        return $dehydrator->getArrayData();
    }

    /**
     * @param array<string, mixed>|array<int, array<string, mixed>>|null $data
     */
    final public static function fromArray(?array $data): ?static
    {
        if ($data === null) {
            return null;
        }

        $hydrator = new Hydrator($data);

        /** @var static $component */
        $component = $hydrator->getComponent(static::class);

        return $component;
    }

    final public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    final public function toJson(bool $prettyPrint = false): string
    {
        $opts = JSON_THROW_ON_ERROR;
        if ($prettyPrint) {
            $opts |= JSON_PRETTY_PRINT;
        }

        return json_encode($this, $opts);
    }

    final public static function fromJson(string $json): static
    {
        $hydrator = Hydrator::forJson($json);

        /** @var static $component */
        $component = $hydrator->getComponent(static::class);

        return $component;
    }
}
