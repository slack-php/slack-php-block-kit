<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\{RequiresAllOf, ValidString,};
use SlackPhp\BlockKit\Hydration\AliasType;
use SlackPhp\BlockKit\Type;

#[AliasType(Type::IMAGE), RequiresAllOf('image_url', 'alt_text')]
class BlockImage extends Block
{
    #[Property('image_url'), ValidString(3000)]
    public ?string $imageUrl;

    #[Property('alt_text'), ValidString(2000)]
    public ?string $altText;

    #[Property, ValidString(2000)]
    public ?PlainText $title;

    public function __construct(
        ?string $imageUrl = null,
        ?string $altText = null,
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
        $this->title = PlainText::wrap($text);

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
}
