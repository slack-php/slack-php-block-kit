<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\{Component, Tools\HydrationData, Tools\Validator};

class Fields extends Component
{
    /** @var Text[] */
    public array $fields = [];

    /**
     * @param self|iterable<string|Text>|array<string, string|Text>|null $fields
     */
    public static function wrap(self|iterable|null $fields): ?self
    {
        if ($fields instanceof self || $fields === null) {
            return $fields;
        }

        return new self($fields);
    }

    /**
     * @param iterable<string, string|Text> $map
     */
    public static function fromMap(iterable $map, bool $groupOutput = false): self
    {
        $fields = self::mapToList($map);

        if ($groupOutput) {
            $fields = self::rowsToGroups($fields);
        }

        return new self($fields);
    }

    /**
     * @param iterable<string[]|Text[]> $pairs
     */
    public static function fromPairs(iterable $pairs, bool $groupOutput = false): self
    {
        $fields = self::pairsToList($pairs);

        if ($groupOutput) {
            $fields = self::rowsToGroups($fields);
        }

        return new self($fields);
    }

    /**
     * @param iterable<string|Text>|array<string, string|Text>|null $fields
     */
    public function __construct(?iterable $fields = null)
    {
        parent::__construct();
        $this->fields($fields);
    }

    /**
     * @param iterable<string|Text>|array<string, string|Text>|null $fields
     */
    public function fields(?iterable $fields): self
    {
        $fields ??= [];
        $this->fields = [];

        if (is_array($fields) && !array_is_list($fields)) {
            $fields = self::fromMap($fields);
        }

        foreach ($fields as $field) {
            $this->add(Text::wrap($field));
        }

        return $this;
    }

    private function add(Text $field): void
    {
        $this->fields[] = $field->limitLength(2000);
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->validateCollection('fields', 10);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return array_map(fn (Text $field) => $field->toArray(), $this->fields);
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        foreach ($data->useComponents(null) as $field) {
            $this->add(Text::fromArray($field));
        }

        parent::hydrateFromArrayData($data);
    }

    /**
     * @param iterable<string, string|Text> $map
     * @return iterable<string|Text>
     */
    private static function mapToList(iterable $map): iterable
    {
        foreach ($map as $key => $value) {
            yield from [$key, $value];
        }
    }

    /**
     * @param iterable<array<string|Text>> $pairs
     * @return iterable<string|Text>
     */
    private static function pairsToList(iterable $pairs): iterable
    {
        foreach ($pairs as $values) {
            yield from $values;
        }
    }

    /**
     * @param iterable<string|Text> $fields
     * @return iterable<string|Text>
     */
    private static function rowsToGroups(iterable $fields): iterable
    {
        $regroup = function (array $items): array {
            $items = array_pad($items, 4, '?');
            [$items[1], $items[2]] = [$items[2], $items[1]];

            return $items;
        };

        $buffer = [];
        foreach ($fields as $field) {
            $buffer[] = $field;
            if (count($buffer) === 4) {
                yield from $regroup($buffer);
                $buffer = [];
            }
        }

        if (!empty($buffer)) {
            yield from $regroup($buffer);
        }
    }
}
