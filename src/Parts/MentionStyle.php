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
class MentionStyle extends Component
{
    use HasBold;
    use HasItalic;
    use HasStrike;

    #[Property]
    public ?bool $highlight;

    #[Property('client_highlight')]
    public ?bool $clientHighlight;

    #[Property]
    public ?bool $unlink;

    public function __construct(
        ?bool $bold = null,
        ?bool $italic = null,
        ?bool $strike = null,
        ?bool $highlight = null,
        ?bool $clientHighlight = null,
        ?bool $unlink = null,
    ) {
        parent::__construct();
        $this->bold($bold);
        $this->italic($italic);
        $this->strike($strike);
        $this->highlight($highlight);
        $this->clientHighlight($clientHighlight);
        $this->unlink($unlink);
    }

    public function highlight(?bool $highlight): self
    {
        $this->highlight = $highlight;

        return $this;
    }

    public function clientHighlight(?bool $clientHighlight): self
    {
        $this->clientHighlight = $clientHighlight;

        return $this;
    }

    public function unlink(?bool $unlink): self
    {
        $this->unlink = $unlink;

        return $this;
    }
}
