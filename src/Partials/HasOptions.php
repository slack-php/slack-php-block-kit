<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Partials;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\HydrationData;

trait HasOptions
{
    /** @var Option[]|array */
    private $options = [];

    /** @var Option[]|array */
    private $initialOptions = [];

    /** @var OptionsConfig|null */
    private $config;

    /**
     * @return OptionsConfig
     */
    private function config(): OptionsConfig
    {
        if (!$this->config) {
            $this->config = $this->getOptionsConfig();
        }

        return $this->config;
    }

    /**
     * @return OptionsConfig
     */
    protected function getOptionsConfig(): OptionsConfig
    {
        return new OptionsConfig();
    }

    /**
     * @param Option $option
     * @param bool $isInitial
     * @return static
     */
    public function addOption(Option $option, bool $isInitial = false): self
    {
        $option->setParent($this);
        $this->options[] = $option;

        if ($isInitial) {
            $this->initialOptions[] = $option;
        }

        return $this;
    }

    /**
     * @param Option[] $options
     * @return static
     */
    public function addOptions(array $options): self
    {
        foreach ($options as $option) {
            $this->addOption($option);
        }

        return $this;
    }

    /**
     * @param string $text
     * @param string $value
     * @param bool $isInitial
     * @return static
     */
    public function option(string $text, string $value, bool $isInitial = false): self
    {
        return $this->addOption(Option::new($text, $value), $isInitial);
    }

    /**
     * @param array<string, string>|string[] $options
     * @return static
     */
    public function options(array $options): self
    {
        foreach ($options as $text => $value) {
            $value = (string) $value;
            $text = is_int($text) ? $value : (string) $text;
            $this->addOption(Option::new($text, $value));
        }

        return $this;
    }

    /**
     * @param string $text
     * @param string $value
     * @return self
     */
    public function initialOption(string $text, string $value): self
    {
        $initialOption = Option::new($text, $value);
        $initialOption->setParent($this);
        $this->initialOptions[] = $initialOption;

        return $this;
    }

    /**
     * @param array<string, string>|string[] $options
     * @return self
     */
    public function initialOptions(array $options): self
    {
        foreach ($options as $text => $value) {
            $value = (string) $value;
            $text = is_int($text) ? $value : (string) $text;
            $this->initialOption($text, $value);
        }

        return $this;
    }

    protected function validateOptions(): void
    {
        $minOptions = (int) $this->config()->getMinOptions();
        if (empty($this->options) || count($this->options) < $minOptions) {
            throw new Exception('You must provide at least %d "options" for %s.', [$minOptions, static::class]);
        }

        $maxOptions = $this->config()->getMaxOptions();
        if ($maxOptions !== null && count($this->options) > $maxOptions) {
            throw new Exception('You must not provide more than %d "options" for %s.', [$maxOptions, static::class]);
        }

        foreach ($this->options as $option) {
            $option->validate();
        }

        $maxInitialOptions = $this->config()->getMaxInitialOptions();
        if ($maxInitialOptions !== null && count($this->initialOptions) > $maxInitialOptions) {
            throw new Exception(
                'You must not provide more than %d "initial_options" for %s.',
                [$maxInitialOptions, static::class]
            );
        }

        foreach ($this->initialOptions as $initialOption) {
            $initialOption->validate();
        }
    }

    protected function validateInitialOptions(): void
    {
        $maxInitialOptions = $this->config()->getMaxInitialOptions();

        if ($maxInitialOptions !== null && count($this->initialOptions) > $maxInitialOptions) {
            throw new Exception(
                'You must not provide more than %d "initial_options" for %s.',
                [$maxInitialOptions, static::class]
            );
        }

        foreach ($this->initialOptions as $initialOption) {
            $initialOption->validate();
        }
    }

    protected function getOptionsAsArray(): array
    {
        return ['options' => array_map(function (Option $option) {
            return $option->toArray();
        }, $this->options)];
    }

    protected function getInitialOptionsAsArray(): array
    {
        if (empty($this->initialOptions)) {
            return [];
        }

        $maxInitialOptions = (int) $this->config()->getMaxInitialOptions();

        if ($maxInitialOptions === 1) {
            return ['initial_option' => $this->initialOptions[0]->toArray()];
        }

        return ['initial_options' => array_map(function (Option $initialOption) {
            return $initialOption->toArray();
        }, $this->initialOptions)];
    }

    protected function hydrateOptions(HydrationData $data): void
    {
        if ($data->has('options')) {
            foreach ($data->useElements('options') as $option) {
                $this->addOption(Option::fromArray($option));
            }
        }

        if ($data->has('initial_option')) {
            $this->initialOptions[] = Option::fromArray($data->useElement('initial_option'));
        }

        if ($data->has('initial_options')) {
            foreach ($data->useElement('initial_options') as $option) {
                $this->initialOptions[] = Option::fromArray($option);
            }
        }
    }
}
