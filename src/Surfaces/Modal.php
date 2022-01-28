<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Collections\BlockCollection;
use SlackPhp\BlockKit\Enums\Type;
use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Tools\{HydrationData, PrivateMetadata, Validator};

/**
 * Modals provide focused spaces ideal for requesting and collecting data from users, or temporarily displaying dynamic
 * and interactive information.
 *
 * @see https://api.slack.com/surfaces
 */
class Modal extends View
{
    public ?PlainText $title;
    public ?PlainText $submit;
    public ?PlainText $close;
    public ?bool $clearOnClose;
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
    }

    public function title(PlainText|string|null $title): self
    {
        $this->title = PlainText::wrap($title)?->limitLength(24);

        return $this;
    }

    public function submit(PlainText|string|null $submit): self
    {
        $this->submit = PlainText::wrap($submit)?->limitLength(24);

        return $this;
    }

    public function close(PlainText|string|null $close): self
    {
        $this->close = PlainText::wrap($close)?->limitLength(24);

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

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireAllOf('title')
            ->preventCondition(
                !empty($this->blocks->filter(fn (Block $b) => $b->type === Type::INPUT)) && empty($this->submit),
                'Modals must have a "submit" button defined if they contain any "input" blocks'
            )
            ->validateSubComponents('submit', 'close');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'title' => $this->title?->toArray(),
            'submit' => $this->submit?->toArray(),
            'close' => $this->close?->toArray(),
            'clear_on_close' => $this->clearOnClose,
            'notify_on_close' => $this->notifyOnClose,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->title(PlainText::fromArray($data->useComponent('title')));
        $this->submit(PlainText::fromArray($data->useComponent('submit')));
        $this->close(PlainText::fromArray($data->useComponent('close')));
        $this->clearOnClose($data->useValue('clear_on_close'));
        $this->notifyOnClose($data->useValue('notify_on_close'));
        parent::hydrateFromArrayData($data);
    }
}
