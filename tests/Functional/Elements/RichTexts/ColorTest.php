<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\Color;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class ColorTest extends TestCase
{
    public function testItCreatesColors(): void
    {
        $expected = [
            'type'  => 'color',
            'value' => '#F405B3',
        ];

        $properties = new Color();
        $properties->value = '#F405B3';

        $constructor = new Color('#F405B3');
        $fluent = Color::new()->value('#F405B3');
        $kit = Kit::color('#F405B3');

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
