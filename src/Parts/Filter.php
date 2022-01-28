<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\{Component, Tools\HydrationData, Tools\Validator};
use SlackPhp\BlockKit\Enums\ConversationType;

class Filter extends Component
{
    public array $include = [];
    public ?bool $excludeExternalSharedChannels = null;
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

    protected function validateInternalData(Validator $validator): void
    {
        $validator->requireOneOf('include', 'exclude_external_shared_channels', 'exclude_bot_users');
        parent::validateInternalData($validator);
    }

    protected function prepareArrayData(): array
    {
        return [
            ...parent::prepareArrayData(),
            'include' => array_map(fn (ConversationType $ct) => $ct->value, $this->include),
            'exclude_external_shared_channels' => $this->excludeExternalSharedChannels,
            'exclude_bot_users' => $this->excludeBotUsers,
        ];
    }

    protected function hydrateFromArrayData(HydrationData $data): void
    {
        $this->include(...$data->useArray('include'));
        $this->excludeExternalSharedChannels($data->useValue('exclude_external_shared_channels'));
        $this->excludeBotUsers($data->useValue('exclude_bot_users'));
        parent::hydrateFromArrayData($data);
    }
}
