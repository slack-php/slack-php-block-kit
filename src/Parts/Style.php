<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Parts;

use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Hydration\OmitType;
use SlackPhp\BlockKit\Parts\Traits\HasBold;
use SlackPhp\BlockKit\Parts\Traits\HasItalic;
use SlackPhp\BlockKit\Parts\Traits\HasStrike;
use SlackPhp\BlockKit\Property;

#[OmitType]
class Style extends Component
{
    use HasBold;
    use HasItalic;
    use HasStrike;

    #[Property]
    public ?bool $code;

    public function __construct(
        ?bool $bold = null,
        ?bool $italic = null,
        ?bool $strike = null,
        ?bool $code = null,
    ) {
        parent::__construct();
        $this->bold($bold);
        $this->italic($italic);
        $this->strike($strike);
        $this->code($code);
    }

    public function code(?bool $code): self
    {
        $this->code = $code;

        return $this;
    }
}
