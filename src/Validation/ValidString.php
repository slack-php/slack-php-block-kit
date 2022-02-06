<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Validation;

use Attribute;
use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Parts\Text;

use function mb_strlen;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ValidString implements PropertyRule
{
    private bool $mbSupported;

    public function __construct(
        private int $maxLength = 0,
        private int $minLength = 1,
    ) {
        $this->mbSupported = function_exists('mb_strlen');
    }

    public function check(Component $component, string $field, mixed $value): void
    {
        if ($value instanceof Text) {
            $value = $value->text;
        }

        if ($value === null) {
            return;
        }

        $string = (string) $value;
        if ($this->getLength($string) < $this->minLength) {
            throw new ValidationException(
                'The "%s" field of a valid "%s" component must be AT LEAST %d character(s) in length',
                [$field, $component->type->value, $this->minLength],
            );
        }

        if ($this->maxLength > 0 && $this->getLength($string) > $this->maxLength) {
            throw new ValidationException(
                'The "%s" field of a valid "%s" component must NOT EXCEED %d characters in length',
                [$field, $component->type->value, $this->maxLength],
            );
        }
    }

    private function getLength(string $str): int
    {
        return $this->mbSupported ? mb_strlen($str, 'UTF-8') : strlen($str);
    }
}
