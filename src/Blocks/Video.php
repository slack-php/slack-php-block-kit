<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Validation\RequiresAllOf;
use SlackPhp\BlockKit\Validation\ValidString;
use SlackPhp\BlockKit\Validation\ValidUrl;

#[RequiresAllOf('alt_text', 'title', 'thumbnail_url', 'video_url')]
class Video extends Block
{
    #[Property, ValidString(200)]
    public ?PlainText $title;

    #[Property('video_url'), ValidUrl]
    public ?string $videoUrl;

    #[Property('thumbnail_url'), ValidUrl]
    public ?string $thumbnailUrl;

    #[Property('alt_text'), ValidString]
    public ?string $altText;

    #[Property, ValidString(200)]
    public ?PlainText $description;

    #[Property('author_name'), ValidString(50)]
    public ?string $authorName;

    #[Property('title_url'), ValidUrl]
    public ?string $titleUrl;

    #[Property('provider_name'), ValidString]
    public ?string $providerName;

    #[Property('provider_icon_url'), ValidUrl]
    public ?string $providerIconUrl;

    public function __construct(
        PlainText|string|null $title = null,
        ?string $videoUrl = null,
        ?string $thumbnailUrl = null,
        ?string $altText = null,
        PlainText|string|null $description = null,
        ?string $authorName = null,
        ?string $titleUrl = null,
        ?string $providerName = null,
        ?string $providerIconUrl = null,
        ?string $blockId = null,
    ) {
        parent::__construct($blockId);
        $this->title($title);
        $this->videoUrl($videoUrl);
        $this->thumbnailUrl($thumbnailUrl);
        $this->altText($altText);
        $this->description($description);
        $this->authorName($authorName);
        $this->titleUrl($titleUrl);
        $this->providerName($providerName);
        $this->providerIconUrl($providerIconUrl);
    }

    public function title(PlainText|string|null $title): self
    {
        $this->title = PlainText::wrap($title);

        return $this;
    }

    public function videoUrl(?string $videoUrl): self
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    public function thumbnailUrl(?string $thumbnailUrl): self
    {
        $this->thumbnailUrl = $thumbnailUrl;

        return $this;
    }

    public function altText(?string $altText): self
    {
        $this->altText = $altText;

        return $this;
    }

    public function description(PlainText|string|null $description): self
    {
        $this->description = PlainText::wrap($description);

        return $this;
    }

    public function authorName(?string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    public function titleUrl(?string $titleUrl): self
    {
        $this->titleUrl = $titleUrl;

        return $this;
    }

    public function providerName(?string $providerName): self
    {
        $this->providerName = $providerName;

        return $this;
    }

    public function providerIconUrl(?string $providerIconUrl): self
    {
        $this->providerIconUrl = $providerIconUrl;

        return $this;
    }
}
