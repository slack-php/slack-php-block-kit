<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Hydration\OmitType;
use SlackPhp\BlockKit\Validation\RequiresAllOf;

#[OmitType, RequiresAllOf('trigger_actions_on')]
class DispatchActionConfig extends Component
{
    /** @var TriggerActionsOn[] */
    #[Property('trigger_actions_on', spread: true)]
    public array $triggerActionsOn = [];

    /**
     * @param array<TriggerActionsOn|string|null> $triggerActionsOn
     */
    public function __construct(array $triggerActionsOn = [])
    {
        parent::__construct();
        $this->triggerActionsOn(...$triggerActionsOn);
    }

    public function triggerActionsOn(TriggerActionsOn|string|null ...$triggerActionsOn): self
    {
        $this->triggerActionsOn = TriggerActionsOn::enumSet(...$this->triggerActionsOn, ...$triggerActionsOn);

        return $this;
    }

    public function triggerActionsOnEnterPressed(): self
    {
        return $this->triggerActionsOn(TriggerActionsOn::ENTER_PRESSED);
    }

    public function triggerActionsOnCharacterEntered(): self
    {
        return $this->triggerActionsOn(TriggerActionsOn::CHARACTER_ENTERED);
    }
}
