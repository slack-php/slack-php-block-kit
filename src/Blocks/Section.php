<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\{Tools\HydrationData, Tools\Validator};
use SlackPhp\BlockKit\Parts\{Text, Fields};
use SlackPhp\BlockKit\Elements\Element;

class Section extends Block
{
    public ?Text $text;
    public ?Fields $fields;
    public ?Element $accessory;

    public function __construct(
        Text|string|null $text = null,
        Fields|array|null $fields = null,
        ?Element $accessory = null,
        ?string $blockId = null
    ) {
        parent::__construct($blockId);
        $this->text($text);
        $this->fields($fields);
        $this->accessory($accessory);
    }

    public function text(Text|string|null $text): self
    {
        $this->text = Text::wrap($text)?->limitLength(3000);

        return $this;
    }

    public function fields(Fields|iterable|null $fields): self
    {
        $this->fields = Fields::wrap($fields);

        return $this;
    }

    public function accessory(?Element $accessory): self
    {
        $this->accessory = $accessory;

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireSomeOf('text', 'fields')
            ->validateSubComponents('text', 'fields', 'accessory');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'text' => $this->text?->toArray(),
            'fields' => $this->fields?->toArray(),
            'accessory' => $this->accessory?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->text(Text::fromArray($data->useComponent('text')));
        $this->fields(Fields::fromArray($data->useComponents('fields') ?: null));
        $this->accessory(Element::fromArray($data->useComponent('accessory')));
        parent::hydrateFromArrayData($data);
    }
}
