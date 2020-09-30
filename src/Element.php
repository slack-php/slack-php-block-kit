<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use JsonSerializable;

abstract class Element implements JsonSerializable
{
    /** @var Element|null */
    protected $parent;

    /** @var array */
    protected $extra;

    /**
     * @return static
     */
    public static function new()
    {
        return new static();
    }

    /**
     * @return Element|null
     */
    public function getParent(): ?Element
    {
        return $this->parent;
    }

    /**
     * @param Element $parent
     * @return static
     */
    public function setParent(Element $parent): Element
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return Type::mapClass(static::class);
    }

    /**
     * Allows setting arbitrary extra fields on an element.
     *
     * Ideally, this is only used to allow setting new Slack features that are not yet implemented in this library.
     *
     * @param string $key
     * @param mixed $value
     * @return static
     */
    public function setExtra(string $key, $value): Element
    {
        if (!is_scalar($value) && !($value instanceof Element)) {
            throw new Exception('Invalid extra field set in %d.', [static::class]);
        }

        $this->extra[$key] = $value;

        return $this;
    }

    /**
     * @throws Exception if the block kit item is invalid (e.g., missing data).
     */
    abstract public function validate(): void;

    /**
     * @return array
     */
    public function toArray(): array
    {
        $this->validate();
        $type = $this->getType();

        $data = !in_array($type, Type::HIDDEN_TYPES, true) ? compact('type') : [];

        foreach ($this->extra ?? [] as $key => $value) {
            $data[$key] = $value instanceof Element ? $value->toArray() : $value;
        }

        return $data;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
