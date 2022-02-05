<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Enums\ConversationType;
use SlackPhp\BlockKit\Property;
use SlackPhp\BlockKit\Tools\Hydration\OmitType;
use SlackPhp\BlockKit\Tools\Validation\RequiresAnyOf;

#[OmitType, RequiresAnyOf('include', 'exclude_external_shared_channels', 'exclude_bot_users')]
class Filter extends Component
{
    #[Property('include', spread: true)]
    public array $include = [];

    #[Property('exclude_external_shared_channels')]
    public ?bool $excludeExternalSharedChannels = null;

    #[Property('exclude_bot_users')]
    public ?bool $excludeBotUsers = null;

    /**
     * @param array<ConversationType|string|null> $include
     */
    public function __construct(
        array $include = [],
        ?bool $excludeExternalSharedChannels = null,
        ?bool $excludeBotUsers = null,
    ) {
        parent::__construct();
        $this->include(...$include);
        $this->excludeExternalSharedChannels($excludeExternalSharedChannels);
        $this->excludeBotUsers($excludeBotUsers);
    }

    public function include(ConversationType|string|null ...$includes): self
    {
        $this->include = ConversationType::enumSet(...$this->include, ...$includes);

        return $this;
    }

    public function includeIm(): self
    {
        return $this->include(ConversationType::IM);
    }

    public function includeMpim(): self
    {
        return $this->include(ConversationType::MPIM);
    }

    public function includePrivate(): self
    {
        return $this->include(ConversationType::PRIVATE);
    }

    public function includePublic(): self
    {
        return $this->include(ConversationType::PUBLIC);
    }

    public function excludeBotUsers(?bool $excludeBotUsers): self
    {
        $this->excludeBotUsers = $excludeBotUsers;

        return $this;
    }

    public function excludeExternalSharedChannels(?bool $excludeExternalSharedChannels): self
    {
        $this->excludeExternalSharedChannels = $excludeExternalSharedChannels;

        return $this;
    }
}
