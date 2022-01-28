<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\{Collections\ContextCollection, Tools\HydrationData, Tools\Validator};
use SlackPhp\BlockKit\Elements\Image;
use SlackPhp\BlockKit\Parts\Text;

class Context extends Block
{
    public ContextCollection $elements;

    public static function fromText(Text|string $text): self
    {
        return new self([Text::wrap($text)]);
    }

    /**
     * @param array<Image|Text|string|null> $elements
     */
    public function __construct(array $elements = [], ?string $blockId = null)
    {
        parent::__construct($blockId);
        $this->elements = new ContextCollection();
        $this->elements(...$elements);
    }

    public function elements(Image|Text|string|null ...$elements): self
    {
        $elements = array_map(fn (mixed $el) => is_string($el) ? Text::wrap($el) : $el, $elements);
        $this->elements->append(...$elements);

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->validateCollection('elements', max: 10, min: 1);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'elements' => $this->elements->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->elements = ContextCollection::fromArray($data->useComponents('elements'));
        parent::hydrateFromArrayData($data);
    }
}
