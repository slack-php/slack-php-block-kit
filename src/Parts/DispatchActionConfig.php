<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\{Component, Tools\HydrationData, Tools\Validator};
use SlackPhp\BlockKit\Enums\TriggerActionsOn;

class DispatchActionConfig extends Component
{
    /** @var TriggerActionsOn[] */
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

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireAllOf('trigger_actions_on');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'trigger_actions_on' => array_map(fn (TriggerActionsOn $tao) => $tao->value, $this->triggerActionsOn),
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->triggerActionsOn(...$data->useArray('trigger_actions_on'));
        parent::hydrateFromArrayData($data);
    }
}
