<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use RuntimeException;
use Throwable;

class Exception extends RuntimeException
{
    public function __construct($message = "", array $args = [], $code = 0, Throwable $previous = null)
    {
        $message = $args ? vsprintf($message, $args) : $message;

        parent::__construct("Slack BlockKit Error: {$message}", $code, $previous);
    }
}
