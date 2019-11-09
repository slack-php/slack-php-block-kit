<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use Jeremeamia\Slack\BlockKit\Surfaces\Surface;

interface Renderer
{
    public function render(Surface $surface): string;
}
