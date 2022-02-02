<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Collections\BlockCollection;
use SlackPhp\BlockKit\Tools\{HydrationData, PrivateMetadata, Validator};

/**
 * A Workflow Step surface are a special case of a Modal, with limited properties, and are used to configure an app's
 * custom workflow step.
 *
 * @see https://api.slack.com/workflows/steps#handle_config_view
 */
class WorkflowStep extends Surface
{
    use HasIdAndMetadata;

    public ?bool $submitDisabled;

    /**
     * @param BlockCollection|array<Block|string>|null $blocks
     */
    public function __construct(
        BlockCollection|array|null $blocks = null,
        ?string $callbackId = null,
        PrivateMetadata|array|string|null $privateMetadata = null,
        ?bool $submitDisabled = null,
    ) {
        parent::__construct($blocks);
        $this->callbackId($callbackId);
        $this->privateMetadata($privateMetadata);
        $this->submitDisabled($submitDisabled);
    }

    public function submitDisabled(?bool $submitDisabled): self
    {
        $this->submitDisabled = $submitDisabled;

        return $this;
    }

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireAllOf('blocks')
            ->validateCollection('blocks', max: static::MAX_BLOCKS, validateIds: true)
            ->validateString('callback_id', 255)
            ->validateString('private_metadata', 3000);
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'callback_id' => $this->callbackId,
            'private_metadata' => $this->privateMetadata,
            'submit_disabled' => $this->submitDisabled,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->callbackId($data->useValue('callback_id'));
        $this->privateMetadata($data->useValue('private_metadata'));
        parent::hydrateFromArrayData($data);
    }
}
