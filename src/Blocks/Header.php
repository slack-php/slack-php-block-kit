<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Blocks;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Partials\PlainText;

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
     * @param bool $emoji
     * @return self
     */
    public function text(string $text, bool $emoji = true): self
    {
        return $this->setText(new PlainText($text, $emoji));
    }

    public function validate(): void
    {
        if (empty($this->text)) {
            throw new Exception('Header must contain "text"');
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['text'] = $this->text->toArray();

        return $data;
    }
}
