<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs;

use DateTime;
use Jeremeamia\Slack\BlockKit\Exception;

class TimePicker extends InputElement
{
    use HasConfirm;
    use HasPlaceholder;

    private const TIME_FORMAT = 'H:i';

    /** @var string */
    private $initialTime;

    public function initialTime(string $time): self
    {
        $dateTime = DateTime::createFromFormat(self::TIME_FORMAT, $time);
        if (!$dateTime) {
            throw new Exception('Time was formatted incorrectly (must be H:i)');
        }

        $this->initialTime = $dateTime->format(self::TIME_FORMAT);

        return $this;
    }

    public function validate(): void
    {
        if (!empty($this->placeholder)) {
            $this->placeholder->validate();
        }

        if (!empty($this->confirm)) {
            $this->confirm->validate();
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->placeholder)) {
            $data['placeholder'] = $this->placeholder->toArray();
        }

        if (!empty($this->initialTime)) {
            $data['initial_time'] = $this->initialTime;
        }

        if (!empty($this->confirm)) {
            $data['confirm'] = $this->confirm->toArray();
        }

        return $data;
    }
}
