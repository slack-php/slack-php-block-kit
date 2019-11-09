<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Renderers;

use Jeremeamia\Slack\BlockKit\Surfaces\AppSurface;

use function json_encode;

use const JSON_PRETTY_PRINT;

class Json implements Renderer
{
    public function render(AppSurface $surface): string
    {
        return json_encode($surface, JSON_PRETTY_PRINT);
    }
}
