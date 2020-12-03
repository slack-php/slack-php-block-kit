<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use RuntimeException;
use Throwable;

class Exception extends RuntimeException
{
    public function __construct(string $message, array $args = [], Throwable $previous = null)
    {
        $message = $args ? vsprintf($message, $args) : $message;

        parent::__construct("Slack Block Kit Error: {$message}", 0, $previous);
    }
}
