<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tools;

use SlackPhp\BlockKit\Exception;
use Throwable;

class HydrationException extends Exception
{
    public function __construct(string $message, array $args = [], Throwable $previous = null)
    {
        parent::__construct("FromArray Error: {$message}", $args, $previous);
    }
}
