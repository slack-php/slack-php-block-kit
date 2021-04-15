<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit;

use Throwable;

class HydrationException extends Exception
{
    public function __construct(string $message, array $args = [], Throwable $previous = null)
    {
        parent::__construct("Hydration Error: {$message}", $args, $previous);
    }
}
