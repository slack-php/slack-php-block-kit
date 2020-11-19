<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Surfaces;

/**
 * App-published messages are dynamic yet transient spaces. They allow users to complete workflows among their
 * Slack conversations.
 *
 * @see https://api.slack.com/surfaces
 */
class Message extends Surface
{
    private const EPHEMERAL = ['response_type' => 'ephemeral'];
    private const IN_CHANNEL = ['response_type' => 'in_channel'];
    private const REPLACE_ORIGINAL = ['replace_original' => 'true'];
    private const DELETE_ORIGINAL = ['delete_original' => 'true'];

    /** @var array|string[] A message can have a directive (e.g., response_type) included along with its blocks. */
    private $directives = [];

    /**
     * Configures message to send to the entire channel.
     *
     * @return Message
     */
    public function inChannel(): self
    {
        $this->directives = self::IN_CHANNEL;

        return $this;
    }

    /**
     * Configures message to send privately to the user.
     *
     * This is default behavior for most interactions, and doesn't necessarily need to be explicitly configured.
     *
     * @return Message
     */
    public function ephemeral(): self
    {
        $this->directives = self::EPHEMERAL;

        return $this;
    }

    /**
     * Configures message to "replace_original" mode.
     *
     * @return Message
     */
    public function replaceOriginal(): self
    {
        $this->directives = self::REPLACE_ORIGINAL;

        return $this;
    }

    /**
     * Configures message to "delete_original" mode.
     *
     * @return Message
     */
    public function deleteOriginal(): self
    {
        $this->directives = self::DELETE_ORIGINAL;

        return $this;
    }

    public function toArray(): array
    {
        return $this->directives + parent::toArray();
    }
}
