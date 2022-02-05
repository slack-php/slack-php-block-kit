<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Validation\RequiresAllOf;

#[RequiresAllOf('text')]
abstract class Text extends Component
{
    #[Property]
    public ?string $text;

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
            return new $explicitClass($text->text);
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
}
