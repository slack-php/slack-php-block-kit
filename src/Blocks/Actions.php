<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Blocks;

use Jeremeamia\Slack\BlockKit\{Element, Exception, Inputs, Type};

class Actions extends BlockElement
{
    private const MAX_ACTIONS = 5;

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
        if (!in_array($element->getType(), Type::ACTION_ELEMENTS)) {
            throw new Exception("Invalid actions element type: {$element->getType()}");
        }

        if (count($this->elements) >= self::MAX_ACTIONS) {
            throw new Exception('Context cannot have more than %d elements', [self::MAX_ACTIONS]);
        }

        $this->elements[] = $element->setParent($this);

        return $this;
    }

    public function newButton(?string $actionId = null): Inputs\Button
    {
        $action = new Inputs\Button($actionId);
        $this->add($action);

        return $action;
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
