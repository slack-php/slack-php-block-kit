<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Partials\HasOptions;
use Jeremeamia\Slack\BlockKit\Partials\Option;

class RadioButtons extends InputElement
{
    use HasConfirm;
    use HasOptions;

    private const MIN_OPTIONS = 1;
    private const MAX_OPTIONS = 10;

    public function validate(): void
    {

        $this->validateOptions();

        $hasInitial = false;

        foreach ($this->options as $option) {
            $option->validate();

            if ($option->isInitial()) {
                if ($hasInitial) {
                    throw new Exception('Only one initial Option is allowed for Radio Buttons');
                }
                $hasInitial = true;
            }
        }

        if (!empty($this->confirm)) {
            $this->confirm->validate();
        }

        if (count($this->options) > self::MAX_OPTIONS) {
            throw new Exception('Option Size cannot exceed %d', [self::MAX_OPTIONS]);
        }

        if (count($this->options) < self::MIN_OPTIONS) {
            throw new Exception('Option Size must be at least %d', [self::MIN_OPTIONS]);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        foreach ($this->options as $option) {
            if ($option->isInitial()) {
                $data['initial_option'] = $option->toArray();
                break;
            }
        }

        $data += $this->getOptionsAsArray();

        if (!empty($this->confirm)) {
            $data['confirm'] = $this->confirm->toArray();
        }

        return $data;
    }
}
