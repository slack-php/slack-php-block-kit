<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Blocks\Input;
use SlackPhp\BlockKit\HydrationData;

/**
 * A Workflow Step surface are a special case of a Modal, with limited properties, and are used to configure an app's
 * custom workflow step.
 *
 * @see https://api.slack.com/workflows/steps#handle_config_view
 */
class WorkflowStep extends Surface
{
    /** @var string */
    private $privateMetadata;

    /** @var string */
    private $callbackId;

    public function callbackId(string $callbackId): self
    {
        $this->callbackId = $callbackId;

        return $this;
    }

    public function privateMetadata(string $privateMetadata): self
    {
        $this->privateMetadata = $privateMetadata;

        return $this;
    }

    public function newInput(?string $blockId = null): Input
    {
        $block = new Input($blockId);
        $this->add($block);

        return $block;
    }

    public function toArray(): array
    {
        $data = [];

        if (!empty($this->callbackId)) {
            $data['callback_id'] = $this->callbackId;
        }

        if (!empty($this->privateMetadata)) {
            $data['private_metadata'] = $this->privateMetadata;
        }

        $data += parent::toArray();

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('callback_id')) {
            $this->callbackId($data->useValue('callback_id'));
        }

        if ($data->has('private_metadata')) {
            $this->privateMetadata($data->useValue('private_metadata'));
        }

        parent::hydrate($data);
    }
}
