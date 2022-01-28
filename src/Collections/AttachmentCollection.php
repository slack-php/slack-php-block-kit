<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Collections;

use SlackPhp\BlockKit\Surfaces\Attachment;

/**
 * @extends ComponentCollection<Attachment>
 */
class AttachmentCollection extends ComponentCollection
{
    protected static function createComponent(array $data): Attachment
    {
        return Attachment::fromArray($data);
    }

    /**
     * @param array<Attachment|self|null> $attachments
     */
    public function __construct(array $attachments = [])
    {
        $this->append(...$attachments);
    }

    public function append(Attachment|self|null ...$attachments): void
    {
        $this->add($attachments, false);
    }

    public function prepend(Attachment|self|null ...$attachments): void
    {
        $this->add($attachments, true);
    }

    protected function prepareItems(array $items): iterable
    {
        foreach ($items as $attachment) {
            if ($attachment instanceof Attachment) {
                yield $attachment;
            } elseif ($attachment instanceof self) {
                yield from $attachment;
            }
        }
    }
}
