<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Collections\OptionSet;
use SlackPhp\BlockKit\Elements\Traits\{HasActionId, HasConfirm, HasOptions, HasOptionsFactory};
use SlackPhp\BlockKit\Enums\OptionType;
use SlackPhp\BlockKit\Parts\Confirm;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Validation\{RequiresAllOf, ValidCollection};

#[RequiresAllOf('options')]
class OverflowMenu extends Element
{
    use HasActionId;
    use HasConfirm;
    use HasOptionsFactory;
    use HasOptions;

    #[Property, ValidCollection(5, 2)]
    public ?OptionSet $options;

    public function __construct(
        ?string $actionId = null,
        OptionSet|array|null $options = null,
        ?Confirm $confirm = null,
    ) {
        parent::__construct();
        $this->actionId($actionId);
        $this->optionType(OptionType::OVERFLOW_MENU);
        $this->options($options);
        $this->confirm($confirm);
    }
}
