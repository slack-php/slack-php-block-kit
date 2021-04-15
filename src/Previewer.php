<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit;

use SlackPhp\BlockKit\Surfaces;

use function rawurlencode;

/**
 * Provides the ability to preview a surface in Slack's Block Kit Builder by generating a URL.
 */
final class Previewer
{
    private const BUILDER_URL = 'https://app.slack.com/block-kit-builder';

    public static function new(): self
    {
        return new self();
    }

    public function preview(Surfaces\Surface $surface): string
    {
        // Prepare/validate the surface.
        if ($surface instanceof Surfaces\Message) {
            // Block Kit Builder doesn't support message directives or fallback text.
            $surface = $surface->asPreviewableMessage();
        } elseif ($surface instanceof Surfaces\Attachment) {
            // Block Kit Builder can only show an attachment within a message.
            $surface = $surface->asMessage();
        } elseif ($surface instanceof Surfaces\WorkflowStep) {
            throw new Exception('The "workflow_step" surface is not compatible with Block Kit Builder');
        }

        // Generate the Block Kit Builder URL.
        return self::BUILDER_URL . '#' . $this->encode($surface);
    }

    /**
     * Encodes a surface into a format understood by Slack and capable of being transmitted in a URL fragment.
     *
     * 1. Encode the surface as JSON.
     * 2. URL encode the JSON.
     * 3. Convert encoded entities for double quotes and colons back to their original characters.
     *
     * @param Surfaces\Surface $surface
     * @return string
     */
    private function encode(Surfaces\Surface $surface): string
    {
        return strtr(rawurlencode($surface->toJson()), ['%22' => '"', '%3A' => ':']);
    }
}
