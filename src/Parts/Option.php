<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Enums\OptionType;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Hydration\OmitType;
use SlackPhp\BlockKit\Tools\Validation\{
    PreventAllOf,
    RequiresAllOf,
    ValidString,
    ValidationException,
};
use SlackPhp\BlockKit\Type;

/**
 * @see https://api.slack.com/reference/block-kit/composition-objects#option
 */
#[OmitType, RequiresAllOf('text', 'value')]
class Option extends Component
{
    #[Property, ValidString(75)]
    public ?Text $text;

    #[Property, ValidString(75)]
    public ?string $value;

    #[Property, ValidString(75)]
    public ?Text $description;

    #[Property, ValidString(3000)]
    public ?string $url;

    public ?bool $initial;
    private OptionType $optionType;

    public static function wrap(self|string|null $option): ?self
    {
        return is_string($option) ? new Option($option, $option) : $option;
    }

    public function __construct(
        Text|string|null $text = null,
        ?string $value = null,
        Text|string|null $description = null,
        ?string $url = null,
        ?bool $initial = null,
        OptionType $optionType = OptionType::SELECT_MENU,
    ) {
        parent::__construct();
        $this->optionType($optionType);
        $this->text($text);
        $this->value($value);
        $this->description($description);
        $this->url($url);
        $this->initial($initial);
        $this->validator->addPreValidation($this->preventInvalidOptionSituations(...));
    }

    public function text(Text|string|null $text): self
    {
        if ($text instanceof Text) {
            $this->text = $text;
        } elseif ($this->optionType->allowsMarkdown()) {
            $this->text = MrkdwnText::wrap($text);
        } else {
            $this->text = PlainText::wrap($text);
        }

        return $this;
    }

    public function value(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function description(Text|string|null $description): self
    {
        if ($description instanceof Text) {
            $this->description = $description;
        } elseif ($this->optionType->allowsMarkdown()) {
            $this->description = MrkdwnText::wrap($description);
        } else {
            $this->description = PlainText::wrap($description);
        }

        return $this;
    }

    public function url(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function initial(?bool $initial): self
    {
        $this->initial = $initial;

        return $this;
    }

    public function optionType(?OptionType $optionType): self
    {
        $this->optionType = $optionType;
        if (!$this->optionType->allowsMarkdown()) {
            $this->text = PlainText::wrap($this->text ?? null);
            $this->description = PlainText::wrap($this->description ?? null);
        }

        return $this;
    }

    public function hash(): string
    {
        return hash('sha256', "{$this->text?->text}|{$this->value}");
    }

    private function preventInvalidOptionSituations(): void
    {
        $preventFieldsRule = new PreventAllOf(...$this->optionType->fieldsToPrevent());
        $preventFieldsRule->check($this);

        if ($this->text?->type === Type::MRKDWNTEXT && !$this->optionType->allowsMarkdown()) {
            throw new ValidationException(
                'The "text" property of a %s option may only be plain_text',
                [$this->optionType->componentName()],
            );
        }

        if ($this->description?->type === Type::MRKDWNTEXT && !$this->optionType->allowsMarkdown()) {
            throw new ValidationException(
                'The "description" property of a %s option may only be plain_text',
                [$this->optionType->componentName()],
            );
        }
    }
}
