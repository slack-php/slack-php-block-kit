<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use Jeremeamia\Slack\BlockKit\Surfaces;

use function rawurlencode;

abstract class Kit
{
    public static function newAppHome(): Surfaces\AppHome
    {
        return new Surfaces\AppHome();
    }

    public static function newMessage(): Surfaces\Message
    {
        return new Surfaces\Message();
    }

    public static function newModal(): Surfaces\Modal
    {
        return new Surfaces\Modal();
    }

    public static function preview(Surfaces\Surface $surface): string
    {
        if ($surface instanceof Surfaces\Message) {
            // Block Kit Builder doesn't support message directives.
            $surface->directives([]);
        } elseif ($surface instanceof Surfaces\Attachment) {
            // Block Kit Builder can only show an attachment within a message.
            $surface = self::newMessage()->addAttachment($surface);
        } elseif ($surface instanceof Surfaces\WorkflowStep) {
            throw new Exception('The "workflow_step" surface is not compatible with Block Kit Builder');
        }

        $encoded = str_replace(['%22', '%3A'], ['"', ':'], rawurlencode($surface->toJson()));

        return "https://app.slack.com/block-kit-builder#{$encoded}";
    }
}
