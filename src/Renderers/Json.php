<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Renderers;

use Jeremeamia\Slack\BlockKit\Renderer;
use Jeremeamia\Slack\BlockKit\Surfaces\Surface;

use function json_encode;

use const JSON_PRETTY_PRINT;

class Json implements Renderer
{
    public function render(Surface $surface): string
    {
        return json_encode($surface, JSON_PRETTY_PRINT);
    }
}
