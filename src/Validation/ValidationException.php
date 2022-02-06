<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Validation;

use SlackPhp\BlockKit\Exception;

class ValidationException extends Exception
{
    public function withContext(Context $context): self
    {
        $this->message .= " (Context: {$context})";

        return $this;
    }
}
