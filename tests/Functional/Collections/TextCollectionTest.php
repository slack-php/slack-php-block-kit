<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Collections;

use SlackPhp\BlockKit\Collections\TextCollection;
use SlackPhp\BlockKit\Elements\RichTexts\Text;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Parts\Style;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class TextCollectionTest extends TestCase
{
    public function testItCreatesTextCollections(): void
    {
        $expected = [
            [
                'type' => 'text',
                'text' => 'Hello there, ',
            ],
            [
                'type'  => 'text',
                'text'  => 'I am a bold rich text!',
                'style' => [
                    'bold' => true,
                ],
            ],
        ];

        $basic = 'Hello there, ';
        $bold = new Text('I am a bold rich text!', new Style(true));

        $properties = new TextCollection();
        $properties->append($basic);
        $properties->append($bold);

        $constructor = new TextCollection([$basic, $bold]);
        $kit = Kit::textCollection([$basic, $bold]);

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $kit->toArray());
    }
}
