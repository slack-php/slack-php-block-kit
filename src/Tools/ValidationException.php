<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tools;

use SlackPhp\BlockKit\Exception;

class ValidationException extends Exception
{
    public function __construct(string $message, array $args = [], array $context = [])
    {
        $chain = implode(' > ', $context);
        parent::__construct("Validation Error: {$message} ($chain)", $args);
    }
}
