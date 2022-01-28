<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\{Tools\HydrationData, Tools\Validator};
use SlackPhp\BlockKit\Parts\PlainText;

class BlockImage extends Block
{
    public ?PlainText $title;

    public function __construct(
        public ?string $imageUrl = null,
        public ?string $altText = null,
        PlainText|string|null $title = null,
        ?string $blockId = null
    ) {
        parent::__construct($blockId);
        $this->imageUrl($imageUrl);
        $this->altText($altText);
        $this->title($title);
    }

    public function title(PlainText|string|null $text): self
    {
        $this->title = PlainText::wrap($text)?->limitLength(2000);

        return $this;
    }

    public function imageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function altText(?string $alt): self
    {
        $this->altText = $alt;

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireAllOf('image_url', 'alt_text')
            ->validateString('image_url', 3000)
            ->validateString('alt_text', 2000);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'image_url' => $this->imageUrl,
            'alt_text' => $this->altText,
            'title' => $this->title?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->title(PlainText::fromArray($data->useComponent('title')));
        $this->imageUrl($data->useValue('image_url'));
        $this->altText($data->useValue('alt_text'));
        parent::hydrateFromArrayData($data);
    }
}
