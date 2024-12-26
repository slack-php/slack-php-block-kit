<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Validation;

use Attribute;
use SlackPhp\BlockKit\Component;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ValidDateFormat implements PropertyRule
{
    private const ALLOWED_TEMPLATES = [
        'ago',
        'date',
        'date_long',
        'date_long_full',
        'date_long_pretty',
        'date_num',
        'date_pretty',
        'date_short',
        'date_short_pretty',
        'date_slash',
        'day_divider_pretty',
        'time',
        'time_secs',
    ];

    public function check(Component $component, string $field, mixed $value): void
    {
        if ($value === null) {
            return;
        }

        $format = (string) $value;

        $templates = implode(', ', self::ALLOWED_TEMPLATES);
        $templateRegex = implode('|', self::ALLOWED_TEMPLATES);
        $validTemplatesRegex = '/^(?:(?!{[^{}]*}).|{(?:' . $templateRegex . ')})*$/';
        $containsTemplateRegex = '/{(?:' . $templateRegex . ')}/';

        if (preg_match($validTemplatesRegex, $format) !== 1) {
            throw new ValidationException(
                'The "%s" field of a valid "%s" component can only contain valid template strings (%s)',
                [$field, $component->type->value, $templates],
            );
        }

        if (preg_match($containsTemplateRegex, $format) !== 1) {
            throw new ValidationException(
                'The "%s" field of a valid "%s" component must at least contain one valid template string (%s)',
                [$field, $component->type->value, $templates],
            );
        }
    }
}
