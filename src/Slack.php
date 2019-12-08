<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use Jeremeamia\Slack\BlockKit\Surfaces\{AppHome, Message, Modal};
use Jeremeamia\Slack\BlockKit\Renderers\RendererFactory;

abstract class Slack
{
    public static function newAppHome(): AppHome
    {
        return new AppHome();
    }

    public static function newMessage(): Message
    {
        return new Message();
    }

    public static function newModal(): Modal
    {
        return new Modal();
    }

    public static function newRenderer(): RendererFactory
    {
        return new RendererFactory();
    }
}
