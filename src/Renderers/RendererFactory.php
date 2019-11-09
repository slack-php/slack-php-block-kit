<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Renderers;

class RendererFactory
{
    public function forJson(): Json
    {
        return new Json();
    }

    public function forKitBuilder(): KitBuilder
    {
        return new KitBuilder();
    }
}
