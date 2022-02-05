<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit;

use JsonSerializable;
use SlackPhp\BlockKit\Tools\Hydration\Dehydrator;
use SlackPhp\BlockKit\Tools\Hydration\Hydrator;
use SlackPhp\BlockKit\Tools\Hydration\HydrationException;
use SlackPhp\BlockKit\Tools\Validation\{Context, ValidationException, Validator};
use Throwable;

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

    /**
     * @throws ValidationException if the block kit item is invalid (e.g., missing data).
     */
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

    /**
     * @param array<string, mixed>|array<int, array<string, mixed>>|null $data
     * @return static|null
     */
    public static function fromArray(?array $data): ?static
    {
        $component = null;

        if (!empty($data)) {
            $hydrator = new Hydrator($data, static::class);
            /** @var static $component */
            $component = $hydrator->getComponent();
        }

        return $component;
    }
}
