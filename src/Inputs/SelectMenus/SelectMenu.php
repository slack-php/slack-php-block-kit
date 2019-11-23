<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs\SelectMenus;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Partials\Option;

class SelectMenu extends Menu
{
    /** @var Option[]|array */
    private $options;

    public function options(array $options): self
    {
        foreach ($options as $text => $value) {
            $this->options[] = new Option($text, $value);
        }

        return $this;
    }

    public function option(string $text, string $value): self
    {
        $this->options[] = new Option($text, $value);

        return $this;
    }

    public function validate(): void
    {
        parent::validate();

        if (empty($this->options)) {
            throw new Exception("Select menu requires options to be provided");
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        $data['options'] = array_map(function (Option $option) {
            return $option->toArray();
        }, $this->options);

        return $data;
    }
}
