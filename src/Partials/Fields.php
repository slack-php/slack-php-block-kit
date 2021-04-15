<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Partials;

use SlackPhp\BlockKit\{Element, Exception, HydrationData};

class Fields extends Element
{
    /** @var Text[] */
    private $fields = [];

    /**
     * @param Text[]|string[] $fields
     */
    public function __construct(array $fields = [])
    {
        if (!empty($fields)) {
            $this->populate($fields);
        }
    }

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

    /**
     * @param Text[]|string[] $fields
     * @return self
     */
    public function populate(array $fields = []): self
    {
        foreach ($fields as $field) {
            if (!$field instanceof Text) {
                $field = new MrkdwnText($field);
            }

            $this->add($field);
        }

        return $this;
    }

    public function validate(): void
    {
        if (empty($this->fields)) {
            throw new Exception('Fields component must have at least one field.');
        }

        foreach ($this->fields as $field) {
            $field->validate();
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

    protected function hydrate(HydrationData $data): void
    {
        foreach ($data->useElements(null) as $field) {
            $this->add(Text::fromArray($field));
        }

        parent::hydrate($data);
    }
}
