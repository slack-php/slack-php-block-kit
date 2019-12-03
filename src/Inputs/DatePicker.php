<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Inputs;

use DateTime;
use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Partials\PlainText;

class DatePicker extends InputElement
{
    use HasConfirm;

    private const DATE_FORMAT = 'Y-m-d';

    /** @var PlainText */
    private $placeholder;

    /** @var string */
    private $initialDate;

    public function setPlaceholder(PlainText $placeholder): self
    {
        $this->placeholder = $placeholder->setParent($this);

        return $this;
    }

    public function placeholder(string $placeholder): self
    {
        return $this->setPlaceholder(new PlainText($placeholder));
    }

    public function initialDate(string $date): self
    {
        $dateTime = DateTime::createFromFormat(self::DATE_FORMAT, $date);
        if (!$dateTime) {
            throw new Exception('Date was formatted incorrectly (must be Y-m-d)');
        }

        $this->initialDate = $dateTime->format(self::DATE_FORMAT);

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

        if (!empty($this->initialDate)) {
            $data['initial_date'] = $this->initialDate;
        }

        if (!empty($this->confirm)) {
            $data['confirm'] = $this->confirm->toArray();
        }

        return $data;
    }
}
