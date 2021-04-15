<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks\Virtual;

use SlackPhp\BlockKit\Blocks\Section;
use SlackPhp\BlockKit\Exception;

/**
 * A virtual, multi-block element using sections to create a two-column table.
 *
 * Since regular Fields elements only support 10 items (5 rows), this uses one Fields element per row. This supports as
 * many rows as will fit in the message/surface (which supports up to 50 blocks), all with consistent margins.
 */
class TwoColumnTable extends VirtualBlock
{
    /** @var Section|null */
    private $header;

    /** @var bool */
    private $hasRows = false;

    /**
     * @param string|null $blockId
     * @param array|null $rows
     * @param array|null $cols
     * @param string|null $caption
     */
    public function __construct(
        ?string $blockId = null,
        ?array $rows = null,
        ?array $cols = null,
        ?string $caption = null
    ) {
        parent::__construct($blockId);

        if (!empty($caption)) {
            $this->caption($caption);
        }

        if (!empty($cols)) {
            [$left, $right] = $cols;
            $this->cols($left, $right);
        }

        if (!empty($rows)) {
            $this->rows($rows);
        }
    }

    /**
     * Sets a caption (text element) at the top of the table.
     *
     * @param string $caption
     * @return self
     */
    public function caption(string $caption): self
    {
        if (!$this->header) {
            $this->header = new Section();
            $this->prependBlock($this->header);
        }

        $this->header->mrkdwnText($caption);

        return $this;
    }

    /**
     * Sets the left and right column headers.
     *
     * Automatically applies a bold to the header text elements.
     *
     * @param string $left
     * @param string $right
     * @return self
     */
    public function cols(string $left, string $right): self
    {
        if (!$this->header) {
            $this->header = new Section();
            $this->prependBlock($this->header);
        }

        $this->header->fieldList(["*{$left}*", "*{$right}*"]);

        return $this;
    }

    /**
     * Adds a row (with a left and right value) to the table.
     *
     * @param string $left
     * @param string $right
     * @return TwoColumnTable
     */
    public function row(string $left, string $right): self
    {
        $row = new Section();
        $row->fieldList([$left, $right]);
        $this->hasRows = true;

        return $this->appendBlock($row);
    }

    /**
     * Adds multiple rows to the table.
     *
     * Supports list-format (e.g., [[$left, $right], ...]) or map-format (e.g., [$left => $right, ...]) as input.
     *
     * @param array $rows
     * @return TwoColumnTable
     */
    public function rows(array $rows): self
    {
        if (isset($rows[0])) {
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

    public function validate(): void
    {
        if (!$this->hasRows) {
            throw new Exception('TwoColumnTable must contain rows');
        }

        parent::validate();
    }
}
