<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Parts;

use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Parts\Style;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class StyleTest extends TestCase
{
    public function testItCreatesMinimalStyles(): void
    {
        $expected = [];

        $constructor = new Style();
        $fluent = Style::new();
        $kit = Kit::style();

        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }

    public function testItCreatesAdvancedStyles(): void
    {
        $expected = [
            'bold'   => true,
            'italic' => true,
            'strike' => true,
            'code'   => true,
        ];

        $properties = new Style();
        $properties->bold = true;
        $properties->italic = true;
        $properties->strike = true;
        $properties->code = true;

        $constructor = new Style(true, true, true, true);

        $fluent = Style::new()
            ->bold(true)
            ->italic(true)
            ->strike(true)
            ->code(true);

        $kit = Kit::style(true, true, true, true);

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
