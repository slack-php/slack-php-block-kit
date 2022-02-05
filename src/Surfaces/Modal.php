<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Collections\BlockCollection;
use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\PrivateMetadata;
use SlackPhp\BlockKit\Tools\Validation\{RequiresAllOf, ValidationException, ValidString};
use SlackPhp\BlockKit\Type;

/**
 * Modals provide focused spaces ideal for requesting and collecting data from users, or temporarily displaying dynamic
 * and interactive information.
 *
 * @see https://api.slack.com/surfaces
 */
#[RequiresAllOf('blocks', 'title')]
class Modal extends View
{
    #[Property, ValidString(24)]
    public ?PlainText $title;

    #[Property, ValidString(24)]
    public ?PlainText $submit;

    #[Property, ValidString(24)]
    public ?PlainText $close;

    #[Property('clear_on_close')]
    public ?bool $clearOnClose;

    #[Property('notify_on_close')]
    public ?bool $notifyOnClose;

    /**
     * @param BlockCollection|array<Block|string>|null $blocks
     */
    public function __construct(
        BlockCollection|array|null $blocks = null,
        PlainText|string|null $title = null,
        ?string $callbackId = null,
        ?string $externalId = null,
        PrivateMetadata|array|string|null $privateMetadata = null,
        PlainText|string|null $submit = null,
        PlainText|string|null $close = null,
        ?bool $clearOnClose = null,
        ?bool $notifyOnClose = null,
    ) {
        parent::__construct($blocks, $callbackId, $externalId, $privateMetadata);
        $this->title($title);
        $this->submit($submit);
        $this->close($close);
        $this->clearOnClose($clearOnClose);
        $this->notifyOnClose($notifyOnClose);
        $this->validator->addPreValidation(function () {
            $inputs = $this->blocks->filter(fn (Block $b) => $b->type === Type::INPUT);
            if (!empty($inputs) && empty($this->submit)) {
                throw new ValidationException(
                    'Modals must have a "submit" button defined if they contain any "input" blocks',
                );
            }
        });
    }

    public function title(PlainText|string|null $title): self
    {
        $this->title = PlainText::wrap($title);

        return $this;
    }

    public function submit(PlainText|string|null $submit): self
    {
        $this->submit = PlainText::wrap($submit);
        return $this;
    }

    public function close(PlainText|string|null $close): self
    {
        $this->close = PlainText::wrap($close);

        return $this;
    }

    public function clearOnClose(?bool $clearOnClose): self
    {
        $this->clearOnClose = $clearOnClose;

        return $this;
    }

    public function notifyOnClose(?bool $notifyOnClose): self
    {
        $this->notifyOnClose = $notifyOnClose;

        return $this;
    }
}
