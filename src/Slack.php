<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use Jeremeamia\Slack\BlockKit\Surfaces\{AppHome, Message, Modal};

abstract class Slack
{
    public static function message(): Message
    {
        return Message::new();
    }

    public static function modal(): Modal
    {
        return Modal::new();
    }

    public static function appHome(): AppHome
    {
        return AppHome::new();
    }

    public static function rendererForJson(): Renderers\Json
    {
        return new Renderers\Json();
    }

    public static function rendererForKitBuilder(): Renderers\KitBuilderLink
    {
        return new Renderers\KitBuilderLink();
    }
}
