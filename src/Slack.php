<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use Jeremeamia\Slack\BlockKit\Surfaces\{AppHome, Message, Modal};
use Jeremeamia\Slack\BlockKit\Renderers\RendererFactory;

abstract class Slack
{
    public static function newMessage(): Message
    {
        return Message::new();
    }

    public static function newModal(): Modal
    {
        return Modal::new();
    }

    public static function newAppHome(): AppHome
    {
        return AppHome::new();
    }

    public static function newRenderer(): RendererFactory
    {
        return new RendererFactory();
    }
}
