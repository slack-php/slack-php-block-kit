<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\Text;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Parts\Style;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class TextTest extends TestCase
{
    public function testItCreatesMinimalTexts(): void
    {
        $expected = [
            'type' => 'text',
            'text' => 'I am a regular rich text!',
        ];

        $properties = new Text();
        $properties->text = 'I am a regular rich text!';

        $constructor = new Text('I am a regular rich text!');
        $fluent = Text::new()->text('I am a regular rich text!');
        $kit = Kit::text('I am a regular rich text!');

        $properties->validate();
        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }

    public function testItCreatesAdvancedTexts(): void
    {
        $expected = [
            'type'  => 'text',
            'text'  => 'I am a fully styled rich text!',
            'style' => [
                'bold'   => true,
                'italic' => true,
                'strike' => true,
                'code'   => true,
            ],
        ];

        $style = new Style(true, true, true, true);

        $properties = new Text();
        $properties->text = 'I am a fully styled rich text!';
        $properties->style = $style;

        $constructor = new Text('I am a fully styled rich text!', $style);
        $fluent = Text::new()->text('I am a fully styled rich text!')->style($style);
        $kit = Kit::text('I am a fully styled rich text!', $style);

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
