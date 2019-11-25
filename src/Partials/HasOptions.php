<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Partials;

use Jeremeamia\Slack\BlockKit\Exception;

trait HasOptions
{
    /** @var Option[]|array */
    private $options;

    public function options(array $options): self
    {
        foreach ($options as $text => $value) {
            $this->option((string) $text, (string) $value);
        }

        return $this;
    }

    public function option(string $text, string $value): self
    {
        $option = new Option($text, $value);
        $option->setParent($this);
        $this->options[] = $option;

        return $this;
    }

    protected function validateOptions()
    {
        if (empty($this->options)) {
            throw new Exception('You must provide "options".');
        }

        foreach ($this->options as $option) {
            $option->validate();
        }
    }

    protected function getOptionsAsArray(): array
    {
        return ['options' => array_map(function (Option $option) {
            return $option->toArray();
        }, $this->options)];
    }
}
