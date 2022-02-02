<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Collections\{AttachmentCollection, BlockCollection};
use SlackPhp\BlockKit\Enums\MessageDirective;
use SlackPhp\BlockKit\Tools\{HydrationData, Validator};

/**
 * @see https://api.slack.com/surfaces
 */
class Message extends Surface
{
    public ?MessageDirective $directive;
    public ?string $text;
    public ?AttachmentCollection $attachments;
    public ?bool $mrkdwn;
    public ?string $threadTs;

    /**
     * @param BlockCollection|array<Block|string>|null $blocks
     * @param AttachmentCollection|array<Attachment>|null $attachments
     */
    public function __construct(
        BlockCollection|array|null $blocks = null,
        ?MessageDirective $directive = null,
        ?string $text = null,
        AttachmentCollection|array|null $attachments = null,
        ?bool $mrkdwn = null,
        ?string $threadTs = null,
        ?bool $ephemeral = null,
    ) {
        parent::__construct($blocks);
        $this->attachments = AttachmentCollection::wrap($attachments);
        $this->directive($directive ?? ($ephemeral ? MessageDirective::EPHEMERAL : null));
        $this->text($text);
        $this->mrkdwn($mrkdwn);
        $this->threadTs($threadTs);
    }

    /**
     * Configures message to send privately to the user.
     *
     * This is default behavior for most interactions, and doesn't necessarily need to be explicitly configured.
     */
    public function ephemeral(): static
    {
        return $this->directive(MessageDirective::EPHEMERAL);
    }

    /**
     * Configures message to send to the entire channel.
     */
    public function inChannel(): static
    {
        return $this->directive(MessageDirective::IN_CHANNEL);
    }

    /**
     * Configures message to "replace_original" mode.
     */
    public function replaceOriginal(): static
    {
        return $this->directive(MessageDirective::REPLACE_ORIGINAL);
    }

    /**
     * Configures message to "delete_original" mode.
     */
    public function deleteOriginal(): static
    {
        return $this->directive(MessageDirective::DELETE_ORIGINAL);
    }

    public function directive(MessageDirective|array|null $directive): static
    {
        $this->directive = MessageDirective::fromValue($directive);

        return $this;
    }

    public function text(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function mrkdwn(?bool $mrkdwn): static
    {
        $this->mrkdwn = $mrkdwn;

        return $this;
    }

    public function threadTs(?string $threadTs): static
    {
        $this->threadTs = $threadTs;

        return $this;
    }

    public function attachments(AttachmentCollection|Attachment|null ...$attachments): static
    {
        $this->attachments->append(...$attachments);

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireSomeOf('text', 'blocks', 'attachments')
            ->validateString('text')
            ->validateString('thread_ts')
            ->validateCollection('blocks', max: static::MAX_BLOCKS, min: 0, validateIds: true)
            ->validateCollection('attachments', max: 10, min: 0);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...($this->directive?->toArray() ?? []),
            'text' => $this->text,
            'mrkdwn' => $this->mrkdwn,
            'thread_ts' => $this->threadTs,
            ...parent::prepareArrayData(),
            'attachments' => $this->attachments?->toArray(),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->directive(array_filter($data->useValues('response_type', 'replace_original', 'delete_original')));
        $this->text($data->useValue('text'));
        $this->mrkdwn($data->useValue('mrkdwn'));
        $this->threadTs($data->useValue('thread_ts'));
        $this->attachments(...array_map(Attachment::fromArray(...), $data->useComponents('attachments')));
        parent::hydrateFromArrayData($data);
    }
}
