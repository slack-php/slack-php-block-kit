<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Parts;

use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Parts\MentionStyle;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class MentionStyleTest extends TestCase
{
    public function testItCreatesMinimalMentionStyles(): void
    {
        $expected = [];

        $constructor = new MentionStyle();
        $fluent = MentionStyle::new();
        $kit = Kit::mentionStyle();

        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }

    public function testItCreatesAdvancedMentionStyles(): void
    {
        $expected = [
            'bold'             => true,
            'italic'           => true,
            'strike'           => true,
            'highlight'        => true,
            'client_highlight' => true,
            'unlink'           => true,
        ];

        $properties = new MentionStyle();
        $properties->bold = true;
        $properties->italic = true;
        $properties->strike = true;
        $properties->highlight = true;
        $properties->clientHighlight = true;
        $properties->unlink = true;

        $constructor = new MentionStyle(true, true, true, true, true, true);

        $fluent = MentionStyle::new()
            ->bold(true)
            ->italic(true)
            ->strike(true)
            ->highlight(true)
            ->clientHighlight(true)
            ->unlink(true);

        $kit = Kit::mentionStyle(true, true, true, true, true, true);

        $properties->validate();
        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }
}
