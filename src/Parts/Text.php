<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\{Component, Tools\HydrationData, Tools\Validator};

abstract class Text extends Component
{
    public ?string $text;
    private int $minLength = 1;
    private int $maxLength = 0;

    public static function wrap(Text|string|null $text): ?static
    {
        if ($text === null) {
            return null;
        }

        $explicitClass = static::class;
        if (is_string($text)) {
            $textClass = $explicitClass === Text::class ? MrkdwnText::class : $explicitClass;
            return new $textClass($text);
        }

        if (!$text instanceof $explicitClass) {
            $wrapped = new $explicitClass($text->text);
            $wrapped->minLength = $text->minLength;
            $wrapped->maxLength = $text->maxLength;
            return $wrapped;
        }

        return $text;
    }

    public function __construct(?string $text)
    {
        parent::__construct();
        $this->text($text);
    }

    public function text(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function limitLength(int $max, int $min = 1): static
    {
        $this->maxLength = $max;
        $this->minLength = $min;

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->validateString('text', $this->maxLength, $this->minLength);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'text' => $this->text,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->text($data->useValue('text'));
        parent::hydrateFromArrayData($data);
    }
}
