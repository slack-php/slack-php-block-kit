<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\{Tools\HydrationData, Tools\Validator};
use SlackPhp\BlockKit\Parts\PlainText;

class Header extends Block
{
    public ?PlainText $text;

    public function __construct(PlainText|string|null $text = null, ?string $blockId = null)
    {
        parent::__construct($blockId);
        $this->text($text);
    }

    public function text(PlainText|string|null $text): static
    {
        $this->text = PlainText::wrap($text)?->limitLength(150);

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireAllOf('text')
            ->validateSubComponents('text');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'text' => $this->text?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->text(PlainText::fromArray($data->useComponent('text')));
        parent::hydrateFromArrayData($data);
    }
}
