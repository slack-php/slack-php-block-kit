<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Renderers;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Surfaces\Attachment;
use Jeremeamia\Slack\BlockKit\Surfaces\Message;
use Jeremeamia\Slack\BlockKit\Surfaces\Surface;
use Jeremeamia\Slack\BlockKit\Surfaces\WorkflowStep;

use function json_decode;
use function json_encode;

class KitBuilder implements Renderer
{
    public function render(Surface $surface): string
    {
        if ($surface instanceof WorkflowStep) {
            throw new Exception('The "workflow_step" surface is not yet compatible with Block Kit Builder');
        } elseif ($surface instanceof Attachment) {
            $surface = Message::new()->addAttachment($surface);
        } elseif ($surface instanceof Message) {
            $directives = new \ReflectionProperty($surface, 'directives');
            $directives->setAccessible(true);
            $directives->setValue($surface, []);
        }

        $content = $this->encode($surface);

        return $this->createLink($content);
    }

    public function renderJson(string $json): string
    {
        $json = json_decode($json, true);
        unset($json['response_type'], $json['replace_original'], $json['delete_original']);
        $content = $this->encode($json);

        return $this->createLink($content);
    }

    private function createLink(string $content): string
    {
        return "https://app.slack.com/block-kit-builder#" . rawurlencode($content);
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
