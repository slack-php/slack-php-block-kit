<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Enums\{OptionType, Type};
use SlackPhp\BlockKit\Tools\{HydrationData, Validator};

/**
 * @see https://api.slack.com/reference/block-kit/composition-objects#option
 */
class Option extends Component
{
    public ?Text $text;
    public ?string $value;
    public ?Text $description;
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

        $this->text?->limitLength(75);

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

        $this->description?->limitLength(75);

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

    protected function validateInternalData(Validator $validator): void
    {
        $validator
            ->preventAllOf(...$this->optionType->fieldsToPrevent())
            ->preventCondition(
                $this->text?->type === Type::MRKDWNTEXT && !$this->optionType->allowsMarkdown(),
                'The "text" property of a %s option may only be plain_text',
                [$this->optionType->componentName()]
            )
            ->preventCondition(
                $this->description?->type === Type::MRKDWNTEXT && !$this->optionType->allowsMarkdown(),
                'The "description" property of a %s option may only be plain_text',
                [$this->optionType->componentName()]
            )
            ->requireAllOf('text', 'value')
            ->validateString('value', 75)
            ->validateString('url', 3000)
            ->validateSubComponents('text', 'description');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'text' => $this->text?->toArray(),
            'value' => $this->value,
            'description' => $this->description?->toArray(),
            'url' => $this->url,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->text(Text::fromArray($data->useComponent('text')));
        $this->value($data->useValue('value'));
        $this->description(Text::fromArray($data->useComponent('description')));
        $this->url($data->useValue('url'));
        parent::hydrateFromArrayData($data);
    }
}
