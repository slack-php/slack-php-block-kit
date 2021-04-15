<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\HydrationData;
use SlackPhp\BlockKit\Partials\PlainText;

class Header extends BlockElement
{
    /** @var PlainText */
    private $text;

    /**
     * @param string|null $blockId
     * @param string|null $text
     */
    public function __construct(?string $blockId = null, ?string $text = null)
    {
        parent::__construct($blockId);

        if (!empty($text)) {
            $this->text($text);
        }
    }

    public function setText(PlainText $text): self
    {
        $this->text = $text->setParent($this);

        return $this;
    }

    /**
     * @param string $text
     * @param bool|null $emoji
     * @return self
     */
    public function text(string $text, ?bool $emoji = null): self
    {
        return $this->setText(new PlainText($text, $emoji));
    }

    public function validate(): void
    {
        if (empty($this->text)) {
            throw new Exception('Header must contain "text"');
        }
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['text'] = $this->text->toArray();

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('text')) {
            $this->setText(PlainText::fromArray($data->useElement('text')));
        }

        parent::hydrate($data);
    }
}
