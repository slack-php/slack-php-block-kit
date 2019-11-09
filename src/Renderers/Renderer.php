<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Renderers;

use Jeremeamia\Slack\BlockKit\Surfaces\AppSurface;

interface Renderer
{
    public function render(AppSurface $surface): string;
}
