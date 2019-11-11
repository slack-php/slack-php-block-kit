<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs;

use DateTime;
use Jeremeamia\Slack\BlockKit\Partials\{Confirm, PlainText};

class DatePicker extends InputElement
{
    private const DATE_FORMAT = 'Y-m-d';

    /** @var PlainText */
    private $placeholder;

    /** @var string */
    private $initialDate;

    /** @var Confirm */
    private $confirm;

    public function setPlaceholder(PlainText $placeholder): self
    {
        $this->placeholder = $placeholder->setParent($this);

        return $this;
    }

    public function setConfirm(Confirm $confirm): self
    {
        $this->confirm = $confirm->setParent($this);

        return $this;
    }

    public function placeholder(string $placeholder): self
    {
        return $this->setPlaceholder(new PlainText($placeholder));
    }

    public function initialDate(string $date): self
    {
        $this->initialDate = DateTime::createFromFormat(self::DATE_FORMAT, $date)->format(self::DATE_FORMAT);

        return $this;
    }

    public function confirm(string $title, string $text, string $confirm = 'OK', string $deny = 'Cancel'): self
    {
        return $this->setConfirm(new Confirm($title, $text, $confirm, $deny));
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

        if (!empty($this->initialDate)) {
            $data['initial_date'] = $this->initialDate;
        }

        if (!empty($this->confirm)) {
            $data['confirm'] = $this->confirm->toArray();
        }

        return $data;
    }
}
