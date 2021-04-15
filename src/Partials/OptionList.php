<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Partials;

use SlackPhp\BlockKit\Element;
use SlackPhp\BlockKit\HydrationData;

/**
 * A standalone element to use for building a list of options or options group.
 *
 * This is not used in any surfaces, but it can be used to generate an app response to a block_suggestion request.
 */
class OptionList extends Element
{
    use HasOptionGroups {
        initialOption as private;
        initialOptions as private;
    }

    public function validate(): void
    {
        $this->validateOptionGroups();
    }

    public function toArray(): array
    {
        return $this->getOptionGroupsAsArray();
    }

    protected function hydrate(HydrationData $data): void
    {
        $this->hydrateOptionGroups($data);
        parent::hydrate($data);
    }
}
