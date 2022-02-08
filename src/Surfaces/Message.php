<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Collections\{AttachmentCollection, BlockCollection};
use SlackPhp\BlockKit\{FauxProperty, Property};
use SlackPhp\BlockKit\Hydration\OmitType;
use SlackPhp\BlockKit\Validation\{RequiresAnyOf, UniqueIds, ValidCollection, ValidString};

/**
 * @see https://api.slack.com/surfaces
 */
#[OmitType, RequiresAnyOf('blocks', 'text', 'attachments')]
class Message extends Surface
{
    #[Property, ValidCollection(50, 0), UniqueIds]
    public BlockCollection $blocks;

    #[FauxProperty('response_type', 'replace_original', 'delete_original')]
    public ?MessageDirective $directive;

    #[Property, ValidString]
    public ?string $text;

    #[Property, ValidCollection(10, 0)]
    public AttachmentCollection $attachments;

    #[Property]
    public ?bool $mrkdwn;

    #[Property, ValidString]
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
}
