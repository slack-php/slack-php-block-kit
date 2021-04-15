<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Inputs\SelectMenus;

use SlackPhp\BlockKit\HydrationData;
use SlackPhp\BlockKit\Partials\Filter;

class MultiConversationSelectMenu extends MultiSelectMenu
{
    /** @var string[] */
    private $initialConversations;

    /** @var bool */
    private $defaultToCurrentConversation;

    /** @var Filter */
    private $filter;

    /**
     * @param string[] $initialConversations
     * @return static
     */
    public function initialConversations(array $initialConversations): self
    {
        $this->initialConversations = $initialConversations;

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

        if (!empty($this->initialConversations)) {
            $data['initial_conversations'] = $this->initialConversations;
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
        if ($data->has('initial_conversations')) {
            $this->initialConversations($data->useArray('initial_conversations'));
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
