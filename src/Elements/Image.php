<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Tools\HydrationData;
use SlackPhp\BlockKit\Tools\Validator;

class Image extends Element
{
    public function __construct(
        public ?string $imageUrl = null,
        public ?string $altText = null,
    ) {
        parent::__construct();
        $this->imageUrl($imageUrl);
        $this->altText($altText);
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
            ->validateString('image_url', 3000);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'image_url' => $this->imageUrl,
            'alt_text' => $this->altText,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->imageUrl($data->useValue('image_url'));
        $this->altText($data->useValue('alt_text'));
        parent::hydrateFromArrayData($data);
    }
}
