<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Surfaces;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Collections\BlockCollection;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\PrivateMetadata;
use SlackPhp\BlockKit\Validation\RequiresAllOf;

/**
 * A Workflow Step surface are a special case of a Modal, with limited properties, and are used to configure an app's
 * custom workflow step.
 *
 * @see https://api.slack.com/workflows/steps#handle_config_view
 */
#[RequiresAllOf('blocks')]
class WorkflowStep extends Surface
{
    use HasIdAndMetadata;

    #[Property('submit_disabled')]
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
}
