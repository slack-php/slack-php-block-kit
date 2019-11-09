<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use RuntimeException;
use Throwable;

class Exception extends RuntimeException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("Slack BlockKit Error: {$message}", $code, $previous);
    }
}
