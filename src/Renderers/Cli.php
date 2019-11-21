<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Renderers;

use Jeremeamia\Slack\BlockKit\Surfaces\Message;
use Jeremeamia\Slack\BlockKit\Surfaces\Surface;
use Jeremeamia\Slack\BlockKit\Type;

class Cli implements Renderer
{
    private const TAB_CHAR = ' ';
    private const TAB_LENGTH = 2;
    private const DIVIDER_CHAR = '-';
    private const DIVIDER_LENGTH = 40;

    public function render(Surface $surface): string
    {
        return $this->renderSurface($surface->toArray());
    }

    public function renderJson(string $json): string
    {
        return $this->renderSurface(json_decode($json, true));
    }

    private function renderSurface(array $data): string
    {
        $buffer = '';

        // Special handling to messages to add type and visibility information.
        if (!isset($data['type'])) {
            $buffer .= '(•) ';
            $buffer .= $data['response_type'] === Message::EPHEMERAL
                ? "Only visible to you\n"
                : "Visible to channel\n";
            unset($data['response_type']);
            $data['type'] = 'message';
        }

        $buffer .= $this->renderElements($data);

        return $buffer;
    }

    /**
     * Recursively renders the data from a surface and its blocks.
     *
     * @param array $array Surface data
     * @param int $level Indentation level
     * @return string
     */
    private function renderElements(array $array, int $level = 0): string
    {
        // Start with an empty buffer.
        $buffer = '';

        // Setup indentation for current item.
        $tab = str_repeat(self::TAB_CHAR, self::TAB_LENGTH);
        $indent = str_repeat($tab, $level);

        // If the array is a list, render each element in the list.
        if (isset($array[0])) {
            foreach ($array as $subArray) {
                $buffer .= $this->renderElements($subArray, $level);
            }
            return $buffer;
        }

        // For elements with a type, indent and extract the type as a title for the section.
        // Also, apply any custom renderings that are type-specific.
        if (isset($array['type'])) {
            $buffer .= $indent;

            $type = $array['type'];
            unset($array['type']);

            // Render dividers as a line.
            if ($type === Type::DIVIDER) {
                $buffer .= str_repeat(self::DIVIDER_CHAR, self::DIVIDER_LENGTH) . "\n";
                return $buffer;
            }

            // Extract IDs and place them in line with the title.
            $buffer .= $type;
            if (isset($array['block_id'])) {
                $buffer .= " (id#{$array['block_id']})";
                unset($array['block_id']);
            }
            if (isset($array['action_id'])) {
                $buffer .= " (id#{$array['action_id']})";
                unset($array['action_id']);
            }
            $buffer .= ":";

            // If a text type, render the text inline and surrounded by quotes.
            if ($type === Type::PLAINTEXT || $type === Type::MRKDWNTEXT) {
                $buffer .= " \"{$array['text']}\"\n";
                return $buffer;
            } else {
                $buffer .= "\n";
            }
        }

        // Render all properties of an element under it's title/type.
        foreach ($array as $property => $value) {
            $buffer .= "{$indent}{$tab}{$property}:";
            $buffer .= is_array($value) ? "\n{$this->renderElements($value, $level + 2)}" : " {$value}\n";
        }

        return $buffer;
    }
}
