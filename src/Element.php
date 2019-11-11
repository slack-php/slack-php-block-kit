<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use JsonSerializable;

abstract class Element implements JsonSerializable
{
    /** @var Element|null */
    protected $parent;

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
     * @param Element
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
        $showType = !in_array($type, [Type::MESSAGE, Type::FIELDS, Type::CONFIRM], true);

        return $showType ? compact('type') : [];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
