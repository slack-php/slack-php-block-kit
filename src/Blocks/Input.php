<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks;

use SlackPhp\BlockKit\Elements\Input as InputElement;
use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Validation\{RequiresAllOf, ValidString};

/**
 * A block that collects information from users.
 *
 * @see https://api.slack.com/reference/block-kit/blocks#input
 */
#[RequiresAllOf('label', 'element')]
class Input extends Block
{
    #[Property, ValidString(2000)]
    public ?PlainText $label;

    #[Property]
    public ?InputElement $element;

    #[Property]
    public ?bool $optional;

    #[Property, ValidString(2000)]
    public ?PlainText $hint;

    #[Property('dispatch_action')]
    public ?bool $dispatchAction;

    public function __construct(
        PlainText|string|null $label = null,
        ?InputElement $element = null,
        ?bool $optional = null,
        PlainText|string|null $hint = null,
        ?bool $dispatchAction = null,
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
        $this->label = PlainText::wrap($label);

        return $this;
    }

    public function element(InputElement|null $element): self
    {
        $this->element = $element;

        return $this;
    }

    public function hint(PlainText|string|null $hint): self
    {
        $this->hint = PlainText::wrap($hint);

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
}
