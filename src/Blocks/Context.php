<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Blocks;

use Jeremeamia\Slack\BlockKit\Element;
use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Type;
use Jeremeamia\Slack\BlockKit\Partials\{MrkdwnText, PlainText};

class Context extends Block
{
    /** @var Element[] */
    private $elements = [];

    public function add(Element $element): self
    {
        if (!in_array($element->getType(), [Type::IMAGE, Type::MRKDWNTEXT, Type::PLAINTEXT])) {
            throw new Exception("Invalid context element type: {$element->getType()}");
        }

        if (count($this->elements) >= 10) {
            throw new Exception('Context cannot have more than 10 elements');
        }

        $this->elements[] = $element->setParent($this);

        return $this;
    }

    public function plainText(string $text, bool $emoji = true): self
    {
        return $this->add(PlainText::new()->text($text)->emoji($emoji));
    }

    public function mrkdwnText(string $text, bool $verbatim = false): self
    {
        return $this->add(MrkdwnText::new()->text($text)->verbatim($verbatim));
    }

    public function image(string $url, string $altText): self
    {
        return $this->add(Image::new()->url($url)->altText($altText));
    }

    public function validate(): void
    {
        if (empty($this->elements)) {
            throw new Exception('Context must contain at least one element');
        }

        foreach ($this->elements as $element) {
            $element->validate();
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        $data['elements'] = [];
        foreach ($this->elements as $element) {
            $data['elements'][] = $element->toArray();
        }

        return $data;
    }
}
