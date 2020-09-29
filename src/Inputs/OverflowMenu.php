<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Partials\HasOptions;

class OverflowMenu extends InputElement
{
    use HasConfirm;
    use HasOptions;

    private const MIN_OPTIONS = 2;
    private const MAX_OPTIONS = 5;

    public function validate(): void
    {

        $this->validateOptions();

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
        $data += $this->getOptionsAsArray();

        if (!empty($this->confirm)) {
            $data['confirm'] = $this->confirm->toArray();
        }

        return $data;
    }
}
