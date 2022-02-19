<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Blocks\Virtual;

use SlackPhp\BlockKit\Blocks\{Context, Section};
use SlackPhp\BlockKit\Md;

class CodeBlock extends VirtualBlock
{
    public function __construct(
        ?string $code = null,
        ?string $caption = null,
        ?string $blockId = null,
    ) {
        parent::__construct();

        $this->blockId($blockId);

        if ($caption !== null) {
            $this->caption($caption);
        }

        if ($code !== null) {
            $this->code($code);
        }
    }

    public function caption(string $caption): self
    {
        $this->prepend(Context::fromText($caption));

        return $this;
    }

    public function code(string $code): self
    {
        $code = Md::new()->codeBlock($code);
        $this->append(new Section($code));

        return $this;
    }
}
