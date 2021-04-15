<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Inputs\SelectMenus;

use SlackPhp\BlockKit\HydrationData;
use SlackPhp\BlockKit\Partials\Filter;

class ConversationSelectMenu extends SelectMenu
{
    /** @var string */
    private $initialConversation;

    /** @var bool */
    private $responseUrlEnabled;

    /** @var bool */
    private $defaultToCurrentConversation;

    /** @var Filter */
    private $filter;

    /**
     * @param string $initialConversation
     * @return static
     */
    public function initialConversation(string $initialConversation): self
    {
        $this->initialConversation = $initialConversation;

        return $this;
    }

    /**
     * @param bool $enabled
     * @return static
     */
    public function responseUrlEnabled(bool $enabled): self
    {
        $this->responseUrlEnabled = $enabled;

        return $this;
    }

    /**
     * @param bool $enabled
     * @return static
     */
    public function defaultToCurrentConversation(bool $enabled): self
    {
        $this->defaultToCurrentConversation = $enabled;

        return $this;
    }

    /**
     * @param Filter $filter
     * @return static
     */
    public function setFilter(Filter $filter): self
    {
        $this->filter = $filter->setParent($this);

        return $this;
    }

    /**
     * @return Filter
     */
    public function newFilter(): Filter
    {
        $filter = Filter::new();
        $this->setFilter($filter);

        return $filter;
    }

    public function validate(): void
    {
        parent::validate();

        if (!empty($this->filter)) {
            $this->filter->validate();
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->initialConversation)) {
            $data['initial_conversation'] = $this->initialConversation;
        }

        if (!empty($this->responseUrlEnabled)) {
            $data['response_url_enabled'] = $this->responseUrlEnabled;
        }

        if (!empty($this->defaultToCurrentConversation)) {
            $data['default_to_current_conversation'] = $this->defaultToCurrentConversation;
        }

        if (!empty($this->filter)) {
            $data['filter'] = $this->filter->toArray();
        }

        return $data;
    }

    protected function hydrate(HydrationData $data): void
    {
        if ($data->has('initial_conversation')) {
            $this->initialConversation($data->useValue('initial_conversation'));
        }

        if ($data->has('response_url_enabled')) {
            $this->responseUrlEnabled($data->useValue('response_url_enabled'));
        }

        if ($data->has('default_to_current_conversation')) {
            $this->defaultToCurrentConversation($data->useValue('default_to_current_conversation'));
        }

        if ($data->has('filter')) {
            $this->setFilter(Filter::fromArray($data->useElement('filter')));
        }

        parent::hydrate($data);
    }
}
