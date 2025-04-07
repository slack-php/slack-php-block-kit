<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit;

use RuntimeException;
use Throwable;

use function vsprintf;

class Exception extends RuntimeException
{
    /**
     * @param array<string|int> $args
     */
    public function __construct(string $message, array $args = [], ?Throwable $previous = null)
    {
        $message = $args ? vsprintf($message, $args) : $message;

        parent::__construct("Slack Block Kit Error: {$message}", 0, $previous);
    }
}
