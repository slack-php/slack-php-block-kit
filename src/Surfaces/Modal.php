<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Surfaces;

use Jeremeamia\Slack\BlockKit\Partials\PlainText;

class Modal extends Surface
{
    public function toArray(): array
    {
        return [
            'title' => PlainText::new()->text('Modal Test')->toArray(),
            'submit' => PlainText::new()->text('SUBMIT')->toArray(),
            'close' => PlainText::new()->text('CLOSE')->toArray(),
        ] + parent::toArray();
    }
}
