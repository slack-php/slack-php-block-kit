<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Renderers;

use Jeremeamia\Slack\BlockKit\Surfaces\Surface;

interface Renderer
{
    public function render(Surface $surface): string;

    public function renderJson(string $json): string;
}
