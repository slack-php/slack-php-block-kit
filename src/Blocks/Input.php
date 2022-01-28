<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\{Tools\HydrationData, Tools\Validator};
use SlackPhp\BlockKit\Elements\Input as InputElement;
use SlackPhp\BlockKit\Parts\PlainText;

/**
 * A block that collects information from users.
 *
 * @see https://api.slack.com/reference/block-kit/blocks#input
 */
class Input extends Block
{
    public ?PlainText $label;
    public ?PlainText $hint;

    public function __construct(
        PlainText|string|null $label = null,
        public ?InputElement $element = null,
        public ?bool $optional = null,
        PlainText|string|null $hint = null,
        public ?bool $dispatchAction = null,
        ?string $blockId = null,
    ) {
        parent::__construct($blockId);
        $this->label($label);
        $this->element($element);
        $this->optional($optional);
        $this->hint($hint);
        $this->dispatchAction($dispatchAction);
    }

    public function label(PlainText|string|null $label): self
    {
        $this->label = PlainText::wrap($label)?->limitLength(2000);

        return $this;
    }

    public function element(InputElement|null $element): self
    {
        $this->element = $element;

        return $this;
    }

    public function hint(PlainText|string|null $hint): self
    {
        $this->hint = PlainText::wrap($hint)?->limitLength(2000);

        return $this;
    }

    public function optional(?bool $optional = true): self
    {
        $this->optional = $optional;

        return $this;
    }

    public function dispatchAction(?bool $dispatchAction = true): self
    {
        $this->dispatchAction = $dispatchAction;

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireAllOf('label', 'element')
            ->validateSubComponents('label', 'element', 'hint');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'label' => $this->label?->toArray(),
            'element' => $this->element?->toArray(),
            'hint' => $this->hint?->toArray(),
            'optional' => $this->optional,
            'dispatch_action' => $this->dispatchAction,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->label(PlainText::fromArray($data->useComponent('label')));
        $this->element(InputElement::fromArray($data->useComponent('element')));
        $this->hint(PlainText::fromArray($data->useComponent('hint')));
        $this->optional($data->useValue('optional'));
        $this->dispatchAction($data->useValue('dispatch_action'));
        parent::hydrateFromArrayData($data);
    }
}
