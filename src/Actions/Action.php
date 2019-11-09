<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Actions;

use Jeremeamia\Slack\BlockKit\Element;

abstract class Action extends Element
{
    /** @var string */
    private $actionId;

    /**
     * @param string $actionId
     * @return static
     */
    public function actionId(string $actionId): self
    {
        $this->actionId = $actionId;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->actionId)) {
            $data['action_id'] = $this->actionId;
        }

        return $data;
    }
}
