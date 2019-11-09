<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Partials;

use Jeremeamia\Slack\BlockKit\{Element, Exception};

class Fields extends Element
{
    /** @var Text[] */
    private $fields = [];

    /**
     * @param Text $field
     * @return self
     */
    public function add(Text $field): self
    {
        if (count($this->fields) >= 10) {
            throw new Exception('Cannot have more than 10 fields');
        }

        $this->fields[] = $field;

        return $this;
    }

    public function validate(): void
    {
        if (empty($this->fields)) {
            throw new Exception('Fields component must have at least one field.');
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $fields = [];
        foreach ($this->fields as $field) {
            $fields[] = $field->toArray();
        }

        return parent::toArray() + $fields;
    }
}
