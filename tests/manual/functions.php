<?php

declare(strict_types=1);

use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Surfaces\Surface;

function view(Surface $surface): void
{
    echo 'Block Kit Builder: ' . Kit::preview($surface) . "\n";
    echo 'JSON Pretty Print: ' . $surface->toJson(true) . "\n";
}
