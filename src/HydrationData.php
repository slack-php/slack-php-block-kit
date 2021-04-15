<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit;

/**
 * @internal Used by fromArray implementations.
 */
class HydrationData
{
    /** @var array<string, mixed> */
    private $data;

    /** @var array<string, bool> */
    private $consumed;

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

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return isset($this->data[$key]);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function useValue(string $key, $default = null)
    {
        $this->consumed[$key] = true;

        return $this->get($key, $default);
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
    public function useElements(?string $key): array
    {
        return $this->useArray($key);
    }

    /**
     * @param string $key
     * @return array<string, mixed>|null
     */
    public function useElement(string $key): ?array
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
