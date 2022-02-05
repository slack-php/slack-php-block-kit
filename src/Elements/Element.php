<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Elements;

use SlackPhp\BlockKit\Component;

abstract class Element extends Component
{
    // No specific behavior added for general Elements.
    // Most Elements (besides Button, Image, and OverflowMenu) are also an Input, which does add behavior.
}
