<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Renderers;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Surfaces\Surface;

use function json_decode;
use function json_encode;

use const JSON_PRETTY_PRINT;

class Json implements Renderer
{
    public function render(Surface $surface): string
    {
        return $this->encode($surface);
    }

    public function renderJson(string $json): string
    {
        return $this->encode(json_decode($json));
    }

    /**
     * @param object $object
     * @return string
     */
    private function encode(object $object): string
    {
        $json = json_encode($object, JSON_PRETTY_PRINT);
        if (!is_string($json)) {
            throw new Exception('Could not encode surface as JSON');
        }

        return $json;
    }
}
