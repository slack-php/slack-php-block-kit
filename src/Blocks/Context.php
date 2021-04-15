<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Element;
use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\HydrationData;
use SlackPhp\BlockKit\HydrationException;
use SlackPhp\BlockKit\Type;
use SlackPhp\BlockKit\Partials\{MrkdwnText, PlainText};

class Context extends BlockElement
{
    private const MAX_ELEMENTS = 10;

    /** @var Element[] */
    private $elements = [];

    /**
     * @param string|null $blockId
     * @param Element[] $elements
     */
    public function __construct(?string $blockId = null, array $elements = [])
    {
        parent::__construct($blockId);
        foreach ($elements as $element) {
            $this->add($element);
        }
    }

    public function add(Element $element): self
    {
        if (!in_array($element->getType(), Type::CONTEXT_ELEMENTS)) {
            throw new Exception('Invalid context element type: %s', [$element->getType()]);
        }

        if (count($this->elements) >= self::MAX_ELEMENTS) {
            throw new Exception('Context cannot have more than %d elements', [self::MAX_ELEMENTS]);
        }

        $this->elements[] = $element->setParent($this);

        return $this;
    }

    public function plainText(string $text, ?bool $emoji = null): self
    {
        return $this->add(new PlainText($text, $emoji));
    }

    public function mrkdwnText(string $text, ?bool $verbatim = null): self
    {
        return $this->add(new MrkdwnText($text, $verbatim));
    }

    public function image(string $url, string $altText): self
    {
        return $this->add(new Image(null, $url, $altText));
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

    protected function hydrate(HydrationData $data): void
    {
        foreach ($data->useElements('elements') as $element) {
            if (!isset($element['type']) || !in_array($element['type'], Type::CONTEXT_ELEMENTS, true)) {
                throw new HydrationException('Invalid context element type');
            }

            $fromArray = [Type::mapType($element['type']), 'fromArray'];
            if (!is_callable($fromArray)) {
                throw new HydrationException('Invalid element fromArray method');
            }

            $this->add($fromArray($element));
        }

        parent::hydrate($data);
    }
}
