<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tools;

use SlackPhp\BlockKit\Enums\Type;

/**
 * @internal Used by fromArray implementations.
 */
class HydrationData
{
    /** @var array<string, mixed> */
    private array $data;

    /** @var array<string, bool> */
    private array $consumed;

    /**
     * HydrationData constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->consumed = [];
    }

    public function type(): ?Type
    {
        return Type::fromValue($this->useValue('type'));
    }

    public function useValue(string $key, mixed $default = null): mixed
    {
        $this->consumed[$key] = true;

        return $this->data[$key] ?? $default;
    }

    public function useValues(string ...$keys): array
    {
        $values = [];
        foreach ($keys as $key) {
            $this->consumed[$key] = true;
            $values[$key] = $this->data[$key] ?? null;
        }

        return $values;
    }

    /**
     * @param string|null $key
     * @return array<int, mixed>
     */
    public function useArray(?string $key): array
    {
        if ($key === null) {
            $this->consumed += array_fill_keys(array_keys($this->data), true);

            return array_values($this->data);
        }

        $this->consumed[$key] = true;

        return $this->data[$key] ?? [];
    }

    /**
     * @param string|null $key
     * @return array<int, array<string, mixed>>
     */
    public function useComponents(?string $key): array
    {
        return $this->useArray($key);
    }

    /**
     * @param string $key
     * @return array<string, mixed>|null
     */
    public function useComponent(string $key): ?array
    {
        $this->consumed[$key] = true;

        return $this->data[$key] ?? null;
    }

    /**
     * @return array<string, mixed>
     */
    public function getExtra(): array
    {
        return array_diff_key($this->data, $this->consumed);
    }
}
