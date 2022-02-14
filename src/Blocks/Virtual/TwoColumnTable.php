<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks\Virtual;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Blocks\Divider;
use SlackPhp\BlockKit\Blocks\Section;
use Traversable;

/**
 * A virtual, multi-block element using sections to create a two-column table.
 *
 * Since regular Fields elements only support 10 items (5 rows), this uses one Fields element per row. This supports as
 * many rows as will fit in the message/surface (which supports up to 50 blocks), all with consistent margins.
 */
class TwoColumnTable extends VirtualBlock
{
    public ?bool $borders;

    /**
     * @param array<string[]>|array<string, string>|null $rows
     * @param array<string>|null $cols
     */
    public function __construct(
        ?array $rows = null,
        ?array $cols = null,
        ?bool $borders = null,
        ?string $blockId = null,
    ) {
        parent::__construct();
        $this->blockId($blockId);
        $this->borders($borders);

        if (!empty($cols)) {
            [$left, $right] = $cols;
            $this->cols($left, $right);
        }

        if (!empty($rows)) {
            $this->rows($rows);
        }
    }

    /**
     * Sets the left and right column headers.
     *
     * Automatically applies a bold to the header text elements.
     */
    public function cols(string $left, string $right): self
    {
        $this->prepend(new Section(fields: ["*{$left}*", "*{$right}*"]));

        return $this;
    }

    /**
     * Adds a row (with a left and right value) to the table.
     */
    public function row(string $left, string $right): self
    {
        $this->append(new Section(fields: [$left, $right]));

        return $this;
    }

    /**
     * Adds multiple rows to the table.
     *
     * Supports list-format (e.g., [[$left, $right], ...]) or map-format (e.g., [$left => $right, ...]) as input.
     *
     * @param array<string[]>|array<string, string> $rows
     */
    public function rows(array $rows): self
    {
        if (array_is_list($rows)) {
            foreach ($rows as [$left, $right]) {
                $this->row($left, $right);
            }
        } else {
            foreach ($rows as $left => $right) {
                $this->row($left, $right);
            }
        }

        return $this;
    }

    public function borders(?bool $borders): self
    {
        $this->borders = $borders;

        return $this;
    }

    public function getIterator(): Traversable
    {
        if ($this->borders) {
            yield new Divider();
        }

        foreach (parent::getIterator() as $block) {
            yield $block;
            if ($this->borders) {
                yield new Divider();
            }
        }
    }
}
