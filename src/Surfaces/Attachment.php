<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Surfaces;

use Jeremeamia\Slack\BlockKit\Element;

/**
 * Attachments are a surface that represent secondary content within a message, and can only exist within a message.
 *
 * Messages can add one or more attachments that have their own set of blocks.
 *
 * Attachments have other legacy attributes besides "color", but their use is discouraged. You can accomplish all of the
 * same things using blocks. If you want to set the legacy attributes, you can use `setExtra()`, inherited from Element.
 *
 * @see Element::setExtra()
 * @see https://api.slack.com/messaging/composing/layouts#attachments
 */
class Attachment extends Surface
{
    /** @var string */
    private $color;

    /**
     * Sets the hex color of the attachment. It Appears as a border along the left side.
     *
     * This makes sure the `#` is included in the color, in case you forget it.
     *
     * @param string $color
     * @return Attachment
     */
    public function color(string $color): self
    {
        $this->color = '#' . ltrim($color, '#');

        return $this;
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        if (!empty($this->color)) {
            $data['color'] = $this->color;
        }

        return $data;
    }
}
