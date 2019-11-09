<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Blocks;

use Jeremeamia\Slack\BlockKit\{Exception, Surfaces\Surface};
use Jeremeamia\Slack\BlockKit\Partials\PlainText;

class Image extends Block
{
    /** @var PlainText */
    private $title;

    /** @var string */
    private $url;

    /** @var string */
    private $altText;

    public function setTitle(PlainText $title): self
    {
        $this->title = $title->setParent($this);

        return $this;
    }

    public function title(string $text): self
    {
        return $this->setTitle(PlainText::new()->text($text));
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

        $data['image_url'] = $this->url;
        $data['alt_text'] = $this->altText;

        return $data;
    }
}
