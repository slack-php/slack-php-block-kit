<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\{Exception, HydrationData, Surfaces\Surface};
use SlackPhp\BlockKit\Partials\PlainText;

class Image extends BlockElement
{
    /** @var PlainText */
    private $title;

    /** @var string */
    private $url;

    /** @var string */
    private $altText;

    /**
     * @param string|null $blockId
     * @param string|null $url
     * @param string|null $altText
     */
    public function __construct(?string $blockId = null, ?string $url = null, ?string $altText = null)
    {
        parent::__construct($blockId);

        if (!empty($url)) {
            $this->url($url);
        }

        if (!empty($altText)) {
            $this->altText($altText);
        }
    }

    public function setTitle(PlainText $title): self
    {
        $this->title = $title->setParent($this);

        return $this;
    }

    public function title(string $text): self
    {
        return $this->setTitle(new PlainText($text));
    }

    public function url(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function altText(string $alt): self
    {
        $this->altText = $alt;

        return $this;
    }

    public function validate(): void
    {
        if (empty($this->url)) {
            throw new Exception('Image must contain "image_url"');
        }

        if (empty($this->altText)) {
            throw new Exception('Image must contain "alt_text"');
        }

        if (!empty($this->title)) {
            $this->title->validate();
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        $isBlock = $this->getParent() === null || $this->getParent() instanceof Surface;

        if ($isBlock && !empty($this->title)) {
            $data['title'] = $this->title->toArray();
        }

        if (!$isBlock) {
            unset($data['block_id']);
        }

        $data['image_url'] = $this->url;
        $data['alt_text'] = $this->altText;

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('title')) {
            $this->setTitle(PlainText::fromArray($data->useElement('title')));
        }

        if ($data->has('image_url')) {
            $this->url($data->useValue('image_url'));
        }

        if ($data->has('alt_text')) {
            $this->altText($data->useValue('alt_text'));
        }

        parent::hydrate($data);
    }
}
