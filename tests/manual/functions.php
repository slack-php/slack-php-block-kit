<?php

declare(strict_types=1);

use Jeremeamia\Slack\BlockKit\Kit;
use Jeremeamia\Slack\BlockKit\Surfaces\Surface;

function view(Surface $surface)
{
    echo 'Block Kit Builder: ' . Kit::preview($surface) . "\n";
    echo 'JSON Pretty Print: ' . $surface->toJson(true) . "\n";
}
