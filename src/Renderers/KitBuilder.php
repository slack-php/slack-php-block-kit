<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Renderers;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Surfaces\Surface;
use Jeremeamia\Slack\BlockKit\Type;

use function http_build_query;
use function json_decode;
use function json_encode;

class KitBuilder implements Renderer
{
    public function render(Surface $surface): string
    {
        $type = $surface->getType();
        if ($type === Type::WORKFLOW_STEP) {
            throw new Exception('The "workflow_step" surface is not yet compatible with Block Kit Builder');
        }

        $content = $this->encode($type === Type::MESSAGE ? $surface->getBlocks() : $surface);

        return $this->createLink($type, $content);
    }

    public function renderJson(string $json): string
    {
        $json = json_decode($json, true);
        $type = $json['type'] ?? Type::MESSAGE;
        $content = $this->encode($type === Type::MESSAGE ? $json['blocks'] : $json);

        return $this->createLink($type, $content);
    }

    private function createLink(string $type, string $content): string
    {
        $query = [];
        $query['mode'] = $type === Type::APPHOME ? 'appHome' : $type;
        $query[$type === Type::MESSAGE ? 'blocks' : 'view'] = $content;

        return "https://api.slack.com/tools/block-kit-builder?" . http_build_query($query);
    }

    /**
     * @param object|array $object
     * @return string
     */
    private function encode($object): string
    {
        $json = json_encode($object);
        if (!is_string($json)) {
            throw new Exception('Could not encode blocks as JSON for Kit Builder link');
        }

        return $json;
    }
}
