<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tools;

use ArrayAccess;

/**
 * @implements ArrayAccess<string, string|int|float|bool>
 */
class PrivateMetadata implements ArrayAccess
{
    /**
     * @param array<string, string|int|float|bool> $data
     */
    public function __construct(private array $data = [])
    {
    }

    public static function decode(string $base64Encoded): ?self
    {
        $urlEncoded = base64_decode($base64Encoded, true);
        if (!$urlEncoded) {
            return null;
        }

        parse_str($urlEncoded, $data);

        return new self($data);
    }

    /**
     * @param array<string, string|int|float|bool> $data
     * @return string
     */
    public static function encode(array $data): string
    {
        return base64_encode(http_build_query($data));
    }

    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    public function __toString(): string
    {
        return self::encode($this->data);
    }
}
