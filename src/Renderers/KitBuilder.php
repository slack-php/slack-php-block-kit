<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Renderers;

use Jeremeamia\Slack\BlockKit\Surfaces\AppSurface;
use Jeremeamia\Slack\BlockKit\Type;

use function http_build_query, json_encode;

class KitBuilder implements Renderer
{
    public function render(AppSurface $surface): string
    {
        $type = $surface->getType();

        $query = ['mode' => $type === Type::APPHOME ? 'appHome' : $type];
        if ($type === Type::MESSAGE) {
            $query['blocks'] = json_encode($surface->getBlocks());
        } else {
            $query['view'] = json_encode($surface);
        }

        return "https://api.slack.com/tools/block-kit-builder?" . http_build_query($query);
    }
}
