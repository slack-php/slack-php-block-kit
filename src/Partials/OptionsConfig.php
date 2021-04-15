<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Partials;

class OptionsConfig
{
    /** @var int|null Minimum number of options supported. */
    private $minOptions;

    /** @var int|null Maximum number of options supported. */
    private $maxOptions;

    /** @var int|null Maximum number of initial options supported. */
    private $maxInitialOptions;

    public static function new(): self
    {
        return new self();
    }

    public function __construct()
    {
        $this->minOptions = 1;
    }

    /**
     * @return int|null
     */
    public function getMinOptions(): ?int
    {
        return $this->minOptions;
    }

    /**
     * @param int|null $minOptions
     * @return self
     */
    public function setMinOptions(?int $minOptions): self
    {
        $this->minOptions = $minOptions;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxOptions(): ?int
    {
        return $this->maxOptions;
    }

    /**
     * @param int|null $maxOptions
     * @return self
     */
    public function setMaxOptions(?int $maxOptions): self
    {
        $this->maxOptions = $maxOptions;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxInitialOptions(): ?int
    {
        return $this->maxInitialOptions;
    }

    /**
     * @param int|null $maxInitialOptions
     * @return self
     */
    public function setMaxInitialOptions(?int $maxInitialOptions): self
    {
        $this->maxInitialOptions = $maxInitialOptions;

        return $this;
    }
}
